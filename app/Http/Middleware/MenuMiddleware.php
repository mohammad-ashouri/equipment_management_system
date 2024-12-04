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
                            'title' => 'هارد اینترنال',
                            'link' => '/InternalHardDisks',
                            'permission' => "لیست هارد اینترنال",
                            'icon' => 'las la-hdd',
                        ],
                        [
                            'title' => 'درایو نوری',
                            'link' => '/Odds',
                            'permission' => "لیست درایو نوری",
                            'icon' => 'las la-ethernet',
                        ],
                        [
                            'title' => 'موس',
                            'link' => '/Mouses',
                            'permission' => "لیست موس",
                            'icon' => 'las la-mouse',
                        ],
                        [
                            'title' => 'صفحه کلید',
                            'link' => '/Keyboards',
                            'permission' => "لیست صفحه کلید",
                            'icon' => 'las la-keyboard',
                        ],
                        [
                            'title' => 'هدست',
                            'link' => '/Headsets',
                            'permission' => "لیست هدست",
                            'icon' => 'las la-headset',
                        ],
                        [
                            'title' => 'پرینتر',
                            'link' => '/Printers',
                            'permission' => "لیست پرینتر",
                            'icon' => 'las la-print',
                        ],
                        [
                            'title' => 'اسکنر',
                            'link' => '/Scanners',
                            'permission' => "لیست اسکنر",
                            'icon' => 'las la-print',
                        ],
                        [
                            'title' => 'دستگاه کپی',
                            'link' => '/CopyMachines',
                            'permission' => "لیست دستگاه کپی",
                            'icon' => 'las la-print',
                        ],
                        [
                            'title' => 'VOIP',
                            'link' => '/Voips',
                            'permission' => "لیست VOIP",
                            'icon' => 'las la-phone-volume',
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
                            'title' => 'کارت شبکه',
                            'link' => '/NetworkCards',
                            'permission' => "لیست کارت شبکه",
                            'icon' => 'las la-ethernet',
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
                            'icon' => 'lab la-usb',
                        ],
                        [
                            'title' => 'آچار پانچ',
                            'link' => '/PunchWrenches',
                            'permission' => "لیست آچار پانچ",
                            'icon' => 'las la-tools',
                        ],
                        [
                            'title' => 'آچار سوکت',
                            'link' => '/SocketWrenches',
                            'permission' => "لیست آچار سوکت",
                            'icon' => 'las la-tools',
                        ],
                        [
                            'title' => 'آچار استریپر',
                            'link' => '/StripperWrenches',
                            'permission' => "لیست آچار استریپر",
                            'icon' => 'las la-tools',
                        ],
                        [
                            'title' => 'تستر شبکه',
                            'link' => '/CableTesters',
                            'permission' => "لیست تستر شبکه",
                            'icon' => 'las la-tools',
                        ],
                        [
                            'title' => 'Kvm',
                            'link' => '/Kvms',
                            'permission' => "لیست kvm",
                            'icon' => 'lab la-usb',
                        ],
                        [
                            'title' => 'Lan TV',
                            'link' => '/Lantvs',
                            'permission' => "لیست lantv",
                            'icon' => 'las la-tv',
                        ],
                        [
                            'title' => 'رادیو وایرلس',
                            'link' => '/RadioWirelesses',
                            'permission' => "لیست رادیو وایرلس",
                            'icon' => 'las la-wifi',
                        ],
                        [
                            'title' => 'اکسس پوینت',
                            'link' => '/AccessPoints',
                            'permission' => "لیست اکسس پوینت",
                            'icon' => 'las la-wifi',
                        ],
                        [
                            'title' => 'روتر',
                            'link' => '/Routers',
                            'permission' => "لیست روتر",
                            'icon' => 'las la-route',
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
                            'link' => '/ExternalHardDisks',
                            'permission' => "لیست هارد اکسترنال",
                            'icon' => 'las la-hdd',
                        ],
                        [
                            'title' => 'لپ تاپ',
                            'link' => '/Laptops',
                            'permission' => "لیست لپ تاپ",
                            'icon' => 'las la-laptop',
                        ],
                        [
                            'title' => 'تبلت',
                            'link' => '/Tablets',
                            'permission' => "لیست تبلت",
                            'icon' => 'las la-tablet',
                        ],
                        [
                            'title' => 'تلفن رومیزی',
                            'link' => '/Phones',
                            'permission' => "لیست تلفن رومیزی",
                            'icon' => 'las la-phone',
                        ],
                        [
                            'title' => 'تلفن همراه',
                            'link' => '/Mobiles',
                            'permission' => "لیست تلفن همراه",
                            'icon' => 'las la-mobile',
                        ],
                        [
                            'title' => 'پایه دوربین',
                            'link' => '/CameraHolders',
                            'permission' => "لیست پایه دوربین",
                            'icon' => 'las la-tenge',
                        ],
                        [
                            'title' => 'کارت DVB',
                            'link' => '/DVBs',
                            'permission' => "لیست کارت DVB",
                            'icon' => 'las la-satellite-dish',
                        ],
                        [
                            'title' => 'کارت LAN TV',
                            'link' => '/LanTvs',
                            'permission' => "لیست LanTvs",
                            'icon' => 'las la-satellite-dish',
                        ],
                        [
                            'title' => 'سیمکارت',
                            'link' => '/Simcards',
                            'permission' => "لیست سیمکارت",
                            'icon' => 'las la-sim-card',
                        ],
                        [
                            'title' => 'اسپیکر',
                            'link' => '/Speakers',
                            'permission' => "لیست اسپیکر",
                            'icon' => 'las la-volume-up',
                        ],
                        [
                            'title' => 'دستگاه حضور و غیاب',
                            'link' => '/AttendanceSystems',
                            'permission' => "لیست دستگاه حضور و غیاب",
                            'icon' => 'las la-fingerprint',
                        ],
                        [
                            'title' => 'دوربین مدار بسته',
                            'link' => '/Cctvs',
                            'permission' => "لیست دوربین مدار بسته",
                            'icon' => 'las la-video',
                        ],
                        [
                            'title' => 'رکوردر',
                            'link' => '/Recorders',
                            'permission' => "لیست رکوردر",
                            'icon' => 'las la-microphone',
                        ],
                        [
                            'title' => 'وبکم',
                            'link' => '/Webcams',
                            'permission' => "لیست وبکم",
                            'icon' => 'las la-video',
                        ],
                        [
                            'title' => 'فلش مموری',
                            'link' => '/FlashMemories',
                            'permission' => "لیست فلش مموری",
                            'icon' => 'lab la-usb',
                        ],
                        [
                            'title' => 'UPS',
                            'link' => '/Ups',
                            'permission' => "لیست ups",
                            'icon' => 'las la-battery-three-quarters',
                        ],
                        [
                            'title' => 'دیش ماهواره',
                            'link' => '/SatelliteDishes',
                            'permission' => "لیست دیش ماهواره",
                            'icon' => 'las la-satellite-dish',
                        ],
                        [
                            'title' => 'لنز دوربین',
                            'link' => '/CameraLenses',
                            'permission' => "لیست لنز دوربین",
                            'icon' => 'las la-camera',
                        ],
                        [
                            'title' => 'فایندر ماهواره',
                            'link' => '/SatelliteFinders',
                            'permission' => "لیست فایندر ماهواره",
                            'icon' => 'las la-search',
                        ],
                        [
                            'title' => 'کارت صدا',
                            'link' => '/SoundCards',
                            'permission' => "لیست کارت صدا",
                            'icon' => 'las la-file-audio',
                        ],
                        [
                            'title' => 'ویدئو پروژکتور',
                            'link' => '/VideoProjectors',
                            'permission' => "لیست ویدئو پروژکتور",
                            'icon' => 'las la-broadcast-tower',
                        ],
                        [
                            'title' => 'پرده ویدئو پروژکتور',
                            'link' => '/VideoProjectorCurtains',
                            'permission' => "لیست پرده ویدئو پروژکتور",
                            'icon' => 'las la-bookmark',
                        ],
                        [
                            'title' => 'میکروفون',
                            'link' => '/Microphones',
                            'permission' => "لیست میکروفون",
                            'icon' => 'las la-microphone',
                        ],
                        [
                            'title' => 'شارژر باتری',
                            'link' => '/BatteryChargers',
                            'permission' => "لیست شارژر باتری",
                            'icon' => 'las la-battery-full',
                        ],
                        [
                            'title' => 'دوربین',
                            'link' => '/Cameras',
                            'permission' => "لیست دوربین",
                            'icon' => 'las la-camera',
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
                            'link' => '/Chairs',
                            'permission' => "لیست صندلی",
                            'icon' => 'las la-chair',
                        ],
                        [
                            'title' => 'کپسول آتش نشانی',
                            'link' => '/FireExtinguishers',
                            'permission' => "لیست کپسول آتش نشانی",
                            'icon' => 'las la-fire-extinguisher',
                        ],
                        [
                            'title' => 'یخچال',
                            'link' => '/Refrigerators',
                            'permission' => "لیست یخچال",
                            'icon' => 'las la-water',
                        ],
                        [
                            'title' => 'دستگاه دمنده',
                            'link' => '/Blowers',
                            'permission' => "لیست دستگاه دمنده",
                            'icon' => 'las la-fan',
                        ],
                        [
                            'title' => 'جعبه کلید',
                            'link' => '/KeyBoxes',
                            'permission' => "لیست جعبه کلید",
                            'icon' => 'las la-key',
                        ],
                        [
                            'title' => 'فایل کشویی',
                            'link' => '/DrawerFileCabinets',
                            'permission' => "لیست فایل کشویی",
                            'icon' => 'las la-th',
                        ],
                        [
                            'title' => 'کولر گازی',
                            'link' => '/AirConditioners',
                            'permission' => "لیست کولر گازی",
                            'icon' => 'las la-temperature-low',
                        ],
                        [
                            'title' => 'بخاری برقی',
                            'link' => '/Heaters',
                            'permission' => "لیست بخاری برقی",
                            'icon' => 'las la-fire',
                        ],
                        [
                            'title' => 'نردبان',
                            'link' => '/Ladders',
                            'permission' => "لیست نردبان",
                            'icon' => 'las la-swimming-pool',
                        ],
                        [
                            'title' => 'تلوزیون',
                            'link' => '/Televisions',
                            'permission' => "لیست تلوزیون",
                            'icon' => 'las la-tv',
                        ],
                        [
                            'title' => 'میز پینگ پنگ',
                            'link' => '/PingPongTables',
                            'permission' => "لیست میز پینگ پنگ",
                            'icon' => 'las la-table-tennis',
                        ],
                    ]
                ],
                6 => [
                    'title' => 'مدیریت پرسنل',
                    'link' => '/Personnels',
                    'permission' => "لیست پرسنل",
                    'icon' => 'las la-users',
                    'childs' => []
                ],
                7 => [
                    'title' => 'گزارشات',
                    'link' => '#',
                    'permission' => "گزارشات",
                    'icon' => 'las la-folder',
                    'childs' => [
                        [
                            'title' => 'تمامی اقلام',
                            'link' => '/Equipments/All',
                            'permission' => "لیست تمامی اقلام",
                            'icon' => 'las la-file-alt',
                        ],
                    ]
                ],
                9 => [
                    'title' => 'مدیریت کاربران',
                    'link' => '/UserManager',
                    'permission' => "لیست کاربران",
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
