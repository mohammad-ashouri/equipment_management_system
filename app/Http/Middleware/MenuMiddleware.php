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
                        [
                            'title' => 'دسترسی ها',
                            'link' => '/Permissions',
                            'permission' => "لیست دسترسی ها",
                            'icon' => 'las la-user-shield',
                        ],
                        [
                            'title' => 'نقش های کاربری',
                            'link' => '/Roles',
                            'permission' => "لیست نقش ها",
                            'icon' => 'las la-user-tag',
                        ],
                        [
                            'title' => 'ساختمان ها',
                            'link' => '/Buildings',
                            'permission' => "لیست ساختمان",
                            'icon' => 'las la-building',
                        ],
                        [
                            'title' => 'برند',
                            'link' => '/Brands',
                            'permission' => "لیست برند",
                            'icon' => 'las la-copyright',
                        ],
                    ]
                ],
                2 => [
                    'title' => 'تجهیزات سخت افزاری',
                    'link' => '/HardwareEquipments',
                    'permission' => "لیست تجهیزات سخت افزاری",
                    'icon' => 'las la-microchip',
                    'childs' => [
                        [
                            'title' => 'مانیتور',
                            'link' => '/Monitors',
                            'permission' => "لیست مانیتور ها",
                            'icon' => 'las la-database',
                        ],
                        [
                            'title' => 'کیس',
                            'link' => '/Cases',
                            'permission' => "لیست کیس ها",
                            'icon' => 'las la-database',
                        ],
                        [
                            'title' => 'پردازنده',
                            'link' => '/Cpus',
                            'permission' => "لیست پردازنده ها",
                            'icon' => 'las la-microchip',
                        ],
                        [
                            'title' => 'مادربورد',
                            'link' => '/Motherboards',
                            'permission' => "لیست مادربورد ها",
                            'icon' => 'las la-microchip',
                        ],
                        [
                            'title' => 'منبع تغذیه',
                            'link' => '/Powers',
                            'permission' => "لیست منبع تغذیه ها",
                            'icon' => 'las la-bolt',
                        ],
                        [
                            'title' => 'رم',
                            'link' => '/Rams',
                            'permission' => "لیست رم ها",
                            'icon' => 'las la-random',
                        ],
                        [
                            'title' => 'گرافیک',
                            'link' => '/GraphicCards',
                            'permission' => "لیست گرافیک ها",
                            'icon' => 'las la-images',
                        ],
                        [
                            'title' => 'گیرنده ماهواره',
                            'link' => '/SatelliteDishes',
                            'permission' => "لیست گیرنده ماهواره ها",
                            'icon' => 'las la-satellite-dish',
                        ],
                        [
                            'title' => 'کارت شبکه',
                            'link' => '/LanCards',
                            'permission' => "لیست کارت شبکه ها",
                            'icon' => 'las la-ethernet',
                        ],
                        [
                            'title' => 'هارد اینترنال',
                            'link' => '/InternalHards',
                            'permission' => "لیست هارد اینترنال ها",
                            'icon' => 'las la-hdd',
                        ],
                    ]
                ],
                3 => [
                    'title' => 'تجهیزات شبکه',
                    'link' => '/NetworkEquipments',
                    'permission' => "لیست تجهیزات شبکه",
                    'icon' => 'las la-globe-americas',
                    'childs' => [
                        [
                            'title' => 'روتر',
                            'link' => '/Routers',
                            'permission' => "لیست روتر ها",
                            'icon' => 'las la-route',
                        ],
                        [
                            'title' => 'سوییچ',
                            'link' => '/Switches',
                            'permission' => "لیست سوییچ ها",
                            'icon' => 'las la-server',
                        ],
                        [
                            'title' => 'مودم',
                            'link' => '/Modems',
                            'permission' => "لیست مودم ها",
                            'icon' => 'las la-exchange-alt',
                        ],
                        [
                            'title' => 'رک',
                            'link' => '/Racks',
                            'permission' => "لیست رک ها",
                            'icon' => 'las la-cube',
                        ],
                        [
                            'title' => 'دانگل',
                            'link' => '/Dongles',
                            'permission' => "لیست دانگل ها",
                            'icon' => 'las la-usb',
                        ],
                    ]
                ],
                4 => [
                    'title' => 'سایر تجهیزات دیجیتال',
                    'link' => '/OtherEquipments',
                    'permission' => "لیست تجهیزات دیجیتال",
                    'icon' => 'las la-digital-tachograph',
                    'childs' => [
                        [
                            'title' => 'هدست',
                            'link' => '/Headsets',
                            'permission' => "لیست هدست ها",
                            'icon' => 'las la-headset',
                        ],
                        [
                            'title' => 'موس',
                            'link' => '/Mouses',
                            'permission' => "لیست موس ها",
                            'icon' => 'las la-mouse',
                        ],
                        [
                            'title' => 'کیبورد',
                            'link' => '/Keyboards',
                            'permission' => "لیست کیبورد ها",
                            'icon' => 'las la-keyboard',
                        ],
                        [
                            'title' => 'هارد اکسترنال',
                            'link' => '/ExternalHards',
                            'permission' => "لیست هارد اکسترنال ها",
                            'icon' => 'las la-hdd',
                        ],
                        [
                            'title' => 'دوربین',
                            'link' => '/Cameras',
                            'permission' => "لیست دوربین ها",
                            'icon' => 'las la-camera',
                        ],
                        [
                            'title' => 'دوربین',
                            'link' => '/Cameras',
                            'permission' => "لیست دوربین ها",
                            'icon' => 'las la-camera',
                        ],
                        [
                            'title' => 'پایه دوربین',
                            'link' => '/CameraHolders',
                            'permission' => "لیست پایه دوربین ها",
                            'icon' => 'las la-tenge',
                        ],
                        [
                            'title' => 'تلوزیون',
                            'link' => '/Televisions',
                            'permission' => "لیست تلوزیون ها",
                            'icon' => 'las la-tv',
                        ],
                        [
                            'title' => 'تلفن',
                            'link' => '/Phones',
                            'permission' => "لیست تلفن ها",
                            'icon' => 'las la-phone-volume',
                        ],
                        [
                            'title' => 'موبایل',
                            'link' => '/Mobiles',
                            'permission' => "لیست موبایل ها",
                            'icon' => 'las la-mobile',
                        ],
                    ]
                ],
                5 => [
                    'title' => 'تجهیزات پشتیبانی',
                    'link' => '/SupportEquipments',
                    'permission' => "لیست تجهیزات پشتیبانی",
                    'icon' => 'las la-life-ring',
                    'childs' => [
                        [
                            'title' => 'میز',
                            'link' => '/Tables',
                            'permission' => "لیست میز ها",
                            'icon' => 'las la-border-all',
                        ],
                        [
                            'title' => 'صندلی',
                            'link' => '/Chair',
                            'permission' => "لیست صندلی ها",
                            'icon' => 'las la-chair',
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
