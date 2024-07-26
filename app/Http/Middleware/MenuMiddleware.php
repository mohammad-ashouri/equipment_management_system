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
                    'permission' => "دسترسی به منوی مقادیر اولیه",
                    'childs' => [
                        1 => [
                            'title' => 'دسترسی ها',
                            'link' => '/Permissions',
                            'permission' => "دسترسی به منوی دسترسی ها",
                            'icon' => 'las la-user-shield',
                        ],
                        2 => [
                            'title' => 'نقش های کاربری',
                            'link' => '/Roles',
                            'permission' => "دسترسی به منوی نقش های کاربری",
                            'icon' => 'las la-user-tag',
                        ],
                    ]
                ],
                9 => [
                    'title' => 'مدیریت کاربران',
                    'link' => '/UserManager',
                    'permission' => "دسترسی به منوی مدیریت کاربران",
                    'icon' => 'las la-users',
                    'childs' => []
                ],
                10 => [
                    'title' => 'بکاپ دیتابیس',
                    'link' => '/BackupDatabase',
                    'permission' => "دسترسی به منوی بکاپ دیتابیس",
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
