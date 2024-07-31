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
                            'title' => 'دسترسی',
                            'link' => '/Permissions',
                            'permission' => "لیست دسترسی",
                            'icon' => 'las la-user-shield',
                        ],
                        [
                            'title' => 'نقش های کاربری',
                            'link' => '/Roles',
                            'permission' => "لیست نقش",
                            'icon' => 'las la-user-tag',
                        ],
                        [
                            'title' => 'ساختمان',
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
                            'permission' => "لیست مانیتور",
                            'icon' => 'las la-desktop',
                        ],
                        [
                            'title' => 'کیس',
                            'link' => '/Cases',
                            'permission' => "لیست کیس",
                            'icon' => 'las la-database',
                        ],
                        [
                            'title' => 'پردازنده',
                            'link' => '/Cpus',
                            'permission' => "لیست پردازنده",
                            'icon' => 'las la-microchip',
                        ],
                        [
                            'title' => 'مادربورد',
                            'link' => '/Motherboards',
                            'permission' => "لیست مادربورد",
                            'icon' => 'las la-microchip',
                        ],
                        [
                            'title' => 'منبع تغذیه',
                            'link' => '/Powers',
                            'permission' => "لیست منبع تغذیه",
                            'icon' => 'las la-bolt',
                        ],
                        [
                            'title' => 'رم',
                            'link' => '/Rams',
                            'permission' => "لیست رم",
                            'icon' => 'las la-random',
                        ],
                        [
                            'title' => 'کارت گرافیک',
                            'link' => '/GraphicCards',
                            'permission' => "لیست کارت گرافیک",
                            'icon' => 'las la-images',
                        ],
                        [
                            'title' => 'گیرنده ماهواره',
                            'link' => '/SatelliteDishes',
                            'permission' => "لیست گیرنده ماهواره",
                            'icon' => 'las la-satellite-dish',
                        ],
                        [
                            'title' => 'کارت شبکه',
                            'link' => '/LanCards',
                            'permission' => "لیست کارت شبکه",
                            'icon' => 'las la-ethernet',
                        ],
                        [
                            'title' => 'هارد اینترنال',
                            'link' => '/InternalHards',
                            'permission' => "لیست هارد اینترنال",
                            'icon' => 'las la-hdd',
                        ],
                        [
                            'title' => 'موس',
                            'link' => '/Mouses',
                            'permission' => "لیست موس",
                            'icon' => 'las la-mouse',
                        ],
                        [
                            'title' => 'کیبورد',
                            'link' => '/Keyboards',
                            'permission' => "لیست کیبورد",
                            'icon' => 'las la-keyboard',
                        ],
                        [
                            'title' => 'هدست',
                            'link' => '/Headsets',
                            'permission' => "لیست هدست",
                            'icon' => 'las la-headset',
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
                            'permission' => "لیست روتر",
                            'icon' => 'las la-route',
                        ],
                        [
                            'title' => 'سوییچ',
                            'link' => '/Switches',
                            'permission' => "لیست سوییچ",
                            'icon' => 'las la-server',
                        ],
                        [
                            'title' => 'مودم',
                            'link' => '/Modems',
                            'permission' => "لیست مودم",
                            'icon' => 'las la-exchange-alt',
                        ],
                        [
                            'title' => 'رک',
                            'link' => '/Racks',
                            'permission' => "لیست رک",
                            'icon' => 'las la-cube',
                        ],
                        [
                            'title' => 'دانگل',
                            'link' => '/Dongles',
                            'permission' => "لیست دانگل",
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
                            'title' => 'هارد اکسترنال',
                            'link' => '/ExternalHards',
                            'permission' => "لیست هارد اکسترنال",
                            'icon' => 'las la-hdd',
                        ],
                        [
                            'title' => 'دوربین',
                            'link' => '/Cameras',
                            'permission' => "لیست دوربین",
                            'icon' => 'las la-camera',
                        ],
                        [
                            'title' => 'دوربین',
                            'link' => '/Cameras',
                            'permission' => "لیست دوربین",
                            'icon' => 'las la-camera',
                        ],
                        [
                            'title' => 'پایه دوربین',
                            'link' => '/CameraHolders',
                            'permission' => "لیست پایه دوربین",
                            'icon' => 'las la-tenge',
                        ],
                        [
                            'title' => 'تلوزیون',
                            'link' => '/Televisions',
                            'permission' => "لیست تلوزیون",
                            'icon' => 'las la-tv',
                        ],
                        [
                            'title' => 'تلفن',
                            'link' => '/Phones',
                            'permission' => "لیست تلفن",
                            'icon' => 'las la-phone-volume',
                        ],
                        [
                            'title' => 'موبایل',
                            'link' => '/Mobiles',
                            'permission' => "لیست موبایل",
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
                            'permission' => "لیست میز",
                            'icon' => 'las la-border-all',
                        ],
                        [
                            'title' => 'صندلی',
                            'link' => '/Chair',
                            'permission' => "لیست صندلی",
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
