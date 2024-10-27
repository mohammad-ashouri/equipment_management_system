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
//                        1 => [
//                            'title' => 'دسترسی ها',
//                            'link' => '/Permissions',
//                            'permission' => "دسترسی به منوی دسترسی ها",
//                            'icon' => 'las la-user-shield',
//                        ],
                        2 => [
                            'title' => 'نقش های کاربری',
                            'link' => '/Roles',
                            'permission' => "دسترسی به منوی نقش های کاربری",
                            'icon' => 'las la-user-tag',
                        ],
                        3 => [
                            'title' => 'انواع سند',
                            'link' => '/DocumentTypes',
                            'permission' => "دسترسی به منوی انواع سند",
                            'icon' => 'las la-folder-open',
                        ],
                        4 => [
                            'title' => 'موضوعات صوت',
                            'link' => '/AudiosSubjects',
                            'permission' => "دسترسی به منوی موضوعات صوت",
                            'icon' => 'las la-podcast',
                        ],
                        5 => [
                            'title' => 'قالب سوژه ها',
                            'link' => '/SubjectFormats',
                            'permission' => "دسترسی به منوی قالب سوژه ها",
                            'icon' => 'las la-info',
                        ],
                        6 => [
                            'title' => 'مخاطب سوژه ها',
                            'link' => '/SubjectAudiences',
                            'permission' => "دسترسی به منوی مخاطب سوژه ها",
                            'icon' => 'las la-info',
                        ],
                        7 => [
                            'title' => 'صفت افراد',
                            'link' => '/PersonAdjectives',
                            'permission' => "دسترسی به منوی صفت افراد",
                            'icon' => 'las la-id-card',
                        ],
                        8 => [
                            'title' => 'مدرس دوره',
                            'link' => '/Teachers',
                            'permission' => "دسترسی به منوی مخاطب سوژه ها",
                            'icon' => 'las la-user-circle',
                        ],
                        9 => [
                            'title' => 'موضوعات چند رسانه ای',
                            'link' => '/MultimediaSubjects',
                            'permission' => "دسترسی به منوی موضوع چند رسانه ای",
                            'icon' => 'las la-info',
                        ],
                        10 => [
                            'title' => 'شبکه اجتماعی',
                            'link' => '/SocialMediaPlatforms',
                            'permission' => "دسترسی به منوی شبکه اجتماعی",
                            'icon' => 'las la-share-alt',
                        ],
                    ]
                ],
                2 => [
                    'title' => 'پست ها',
                    'link' => '',
                    'permission' => "دسترسی به منوی پست ها",
                    'icon' => 'las la-folder-open',
                    'childs' => [
                        2 => [
                            'title' => 'اسناد',
                            'link' => '/Posts',
                            'permission' => "دسترسی به منوی اسناد",
                            'icon' => 'las la-file-alt',
                            'childs' => []
                        ],
                        3 => [
                            'title' => 'اسناد خارجی',
                            'link' => '/InternationalDocuments',
                            'permission' => "دسترسی به منوی اسناد خارجی",
                            'icon' => 'las la-passport',
                            'childs' => []
                        ],
                        4 => [
                            'title' => 'سوژه های پژوهشی',
                            'link' => '/ResearchSubjects',
                            'permission' => "دسترسی به منوی سوژه های پژوهشی",
                            'icon' => 'las la-male',
                            'childs' => []
                        ],
                        5 => [
                            'title' => 'سوژه های رسانه ای',
                            'link' => '/MediaSubjects',
                            'permission' => "دسترسی به منوی سوژه های رسانه ای",
                            'icon' => 'las la-video',
                            'childs' => []
                        ],
                        6 => [
                            'title' => 'اساتید',
                            'link' => '/Professors',
                            'permission' => "دسترسی به منوی اساتید",
                            'icon' => 'las la-graduation-cap',
                            'childs' => []
                        ],
                        10 => [
                            'title' => 'یادداشت ها',
                            'link' => '/Notes',
                            'permission' => "دسترسی به منوی یادداشت ها",
                            'icon' => 'las la-sticky-note',
                            'childs' => []
                        ],
                        11 => [
                            'title' => 'کلاس اسناد',
                            'link' => '/DocumentClasses',
                            'permission' => "دسترسی به منوی کلاس اسناد",
                            'icon' => 'las la-school',
                            'childs' => []
                        ],
                        12 => [
                            'title' => 'پرونده ویژه',
                            'link' => '/SpecialCases',
                            'permission' => "دسترسی به منوی پرونده ویژه",
                            'icon' => 'las la-file-archive',
                            'childs' => []
                        ],
                    ]
                ],
                3 => [
                    'title' => 'چند رسانه ای',
                    'link' => '',
                    'permission' => "دسترسی به منوی چند رسانه ای",
                    'icon' => 'las la-photo-video',
                    'childs' => [
                        1 => [
                            'title' => 'صوت ها',
                            'link' => '/Audios',
                            'permission' => "دسترسی به منوی صوت ها",
                            'icon' => 'las la-volume-up',
                            'childs' => []
                        ],
//                        2 => [
//                            'title' => 'فیلم های کوتاه',
//                            'link' => '/ShortVideos',
//                            'permission' => "دسترسی به منوی فیلم های کوتاه",
//                            'icon' => 'las la-film',
//                            'childs' => []
//                        ],
                        3 => [
                            'title' => 'آلبوم تصاویر',
                            'link' => '/PictureAlbum',
                            'permission' => "دسترسی به منوی آلبوم تصاویر",
                            'icon' => 'las la-film',
                            'childs' => []
                        ],
                        4 => [
                            'title' => 'مستند',
                            'link' => '/Documentaries',
                            'permission' => "دسترسی به منوی مستند",
                            'icon' => 'las la-file-video',
                            'childs' => []
                        ],
                        8 => [
                            'title' => 'فضای مجازی',
                            'link' => '/SocialMedia',
                            'permission' => "دسترسی به منوی فضای مجازی",
                            'icon' => 'las la-share-alt',
                            'childs' => []
                        ],
                        9 => [
                            'title' => 'معرفی کتاب',
                            'link' => '/BookIntroductions',
                            'permission' => "دسترسی به منوی معرفی کتاب",
                            'icon' => 'las la-book',
                            'childs' => []
                        ],
                    ]
                ],
                4 => [
                    'title' => 'اسلایدرها',
                    'link' => '/Sliders',
                    'permission' => "دسترسی به منوی اسلایدر",
                    'icon' => 'las la-sliders-h',
                    'childs' => []
                ],
                5 => [
                    'title' => 'ارتباط با ما',
                    'link' => '/ContactUs',
                    'permission' => "لیست ارتباط با ما",
                    'icon' => 'las la-mail-bulk',
                    'childs' => []
                ],
                6 => [
                    'title' => 'تنظیمات سایت',
                    'link' => '/SiteSettings',
                    'permission' => "دسترسی به منوی تنظیمات سایت",
                    'icon' => 'las la-tools',
                    'childs' => []
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
