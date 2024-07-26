<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Blacklist;
use Carbon\Carbon;
use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $agent = new Agent();
        $key = $request->ip();
        $blacklist = Blacklist::firstOrNew(['ip_address' => $key]);

        $lastUpdatedAt = Carbon::parse($blacklist->updated_at);
        $currentTime = Carbon::now();

        if ($lastUpdatedAt->diffInSeconds($currentTime) > 1200) {
            $this->logActivity('Unblock IP=> ' . request()->ip(), request()->ip(), request()->userAgent());
            $blacklist->attempts_count = 30;
            $blacklist->active = 1;
            $blacklist->save();
        }

        if ($blacklist->exists) {
            if ($blacklist->active !== 0) {
                $blacklist->attempts_count -= 1;
                $blacklist->save();
            }

            if ($blacklist->attempts_count <= 0) {
                if ($blacklist->active !== 0) {
                    ActivityLog::create([
                        'activity' => 'Blocked IP=> ' . request()->ip(),
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                        'device' => $agent->device(),
                    ]);
                }
                $blacklist->active = 0;
                $blacklist->save();

                return response()->json(['YouAreLocked' => 'تعداد تلاش‌های شما به پایان رسیده است. لطفاً بعد از یک ساعت مجدداً اقدام کنید.'], 403);
            }
        } else {
            $blacklist->ip_address = $key;
            $blacklist->attempts_count = 30;
            $blacklist->active = 1;
            $blacklist->save();
        }

        $blacklist->updated_at = Carbon::now();
        $blacklist->save();

        return $next($request);
    }
}

