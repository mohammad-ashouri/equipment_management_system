<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Catalogs\Category;
use App\Models\Catalogs\DocumentType;
use App\Models\Catalogs\PersonAdjective;
use App\Models\Catalogs\PostType;
use App\Models\Catalogs\SocialMediaPlatform;
use App\Models\EquipmentLog;
use App\Models\Picture;
use App\Models\Video;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Jenssegers\Agent\Agent;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logActivity($activity, $ip_address, $user_agent, $user_id = null): void
    {
        $agent = new Agent();
        ActivityLog::create([
            'user_id' => $user_id,
            'activity' => json_encode([$activity], true),
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'device' => $agent->device(),
        ]);
    }

    public function alerts($state, $errorVariable, $errorText): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $state,
            'errors' => [
                $errorVariable => [$errorText]
            ]
        ]);
    }

    public function success($state, $messageVariable, $messageText): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $state,
            'message' => [
                $messageVariable => [$messageText]
            ]
        ]);
    }

    public function getMyUserId()
    {
        if (auth()->user()->id) {
            return auth()->user()->id;
        }
        if (session('id')) {
            return session('id');
        }
        abort(403, 'User id not found!');
    }

}
