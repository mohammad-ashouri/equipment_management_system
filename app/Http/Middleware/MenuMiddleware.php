<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('username')) {
            $menus = [
                1 => [
                    'title' => 'مقادیر اولیه',
                    'link' => '',
                    'icon' => 'las la-cogs',
                    'permission' => "لیست مقادیر اولیه",
                    'childs' => [
                        1 => [
                            'title' => 'دسترسی ها',
                            'link' => '/Permissions',
                            'permission' => "لیست دسترسی ها",
                            'icon' => 'las la-user-shield',
                        ],
                        2 => [
                            'title' => 'نقش های کاربری',
                            'link' => '/Roles',
                            'permission' => "لیست نقش ها",
                            'icon' => 'las la-user-tag',
                        ],
                        3 => [
                            'title' => 'ساختمان ها',
                            'link' => '/Buildings',
                            'permission' => "لیست ساختمان",
                            'icon' => 'las la-building',
                        ],
                    ]
                ],
                9 => [
                    'title' => 'مدیریت کاربران',
                    'link' => '/UserManager',
                    'permission' => "لیست مدیریت کاربران",
                    'icon' => 'las la-users',
                    'childs' => []
                ],
                10 => [
                    'title' => 'بکاپ دیتابیس',
                    'link' => '/BackupDatabase',
                    'permission' => "لیست بکاپ دیتابیس",
                    'icon' => 'las la-hdd',
                    'childs' => []
                ],
            ];
            $request->session()->put('menus', $menus);
            return $next($request);
        }
        return response()->redirectToRoute('login');
    }
}
