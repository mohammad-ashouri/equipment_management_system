<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //catalogs
        Permission::create(['name' => 'دسترسی به منوی مقادیر اولیه']);

        Permission::create(['name' => 'لیست نقش ها']);
        Permission::create(['name' => 'ایجاد نقش']);
        Permission::create(['name' => 'ویرایش نقش']);
        Permission::create(['name' => 'نمایش جزئیات نقش']);
        Permission::create(['name' => 'حذف نقش']);
        Permission::create(['name' => 'دسترسی به منوی نقش های کاربری']);

        Permission::create(['name' => 'لیست دسترسی ها']);
        Permission::create(['name' => 'ایجاد دسترسی']);
        Permission::create(['name' => 'ویرایش دسترسی']);
        Permission::create(['name' => 'نمایش جزئیات دسترسی']);
        Permission::create(['name' => 'حذف دسترسی']);
        Permission::create(['name' => 'دسترسی به منوی دسترسی ها']);

        Permission::create(['name' => 'لیست انواع سند']);
        Permission::create(['name' => 'ایجاد نوع سند']);
        Permission::create(['name' => 'ویرایش نوع سند']);
        Permission::create(['name' => 'نمایش جزئیات نوع سند']);
        Permission::create(['name' => 'حذف نوع سند']);
        Permission::create(['name' => 'دسترسی به منوی انواع سند']);

        Permission::create(['name' => 'لیست موضوعات صوت']);
        Permission::create(['name' => 'ایجاد موضوعات صوت']);
        Permission::create(['name' => 'ویرایش موضوعات صوت']);
        Permission::create(['name' => 'نمایش جزئیات موضوعات صوت']);
        Permission::create(['name' => 'حذف موضوعات صوت']);
        Permission::create(['name' => 'دسترسی به منوی موضوعات صوت']);

        Permission::create(['name' => 'لیست قالب سوژه ها']);
        Permission::create(['name' => 'ایجاد قالب سوژه ها']);
        Permission::create(['name' => 'ویرایش قالب سوژه ها']);
        Permission::create(['name' => 'نمایش جزئیات قالب سوژه ها']);
        Permission::create(['name' => 'حذف قالب سوژه ها']);
        Permission::create(['name' => 'دسترسی به منوی قالب سوژه ها']);

        Permission::create(['name' => 'لیست مخاطب سوژه ها']);
        Permission::create(['name' => 'ایجاد مخاطب سوژه ها']);
        Permission::create(['name' => 'ویرایش مخاطب سوژه ها']);
        Permission::create(['name' => 'نمایش جزئیات مخاطب سوژه ها']);
        Permission::create(['name' => 'حذف مخاطب سوژه ها']);
        Permission::create(['name' => 'دسترسی به منوی مخاطب سوژه ها']);

        Permission::create(['name' => 'لیست مدرس دوره']);
        Permission::create(['name' => 'ایجاد مدرس دوره']);
        Permission::create(['name' => 'ویرایش مدرس دوره']);
        Permission::create(['name' => 'نمایش جزئیات مدرس دوره']);
        Permission::create(['name' => 'حذف مدرس دوره']);
        Permission::create(['name' => 'دسترسی به منوی مدرس دوره']);

        Permission::create(['name' => 'لیست صفت افراد']);
        Permission::create(['name' => 'ایجاد صفت افراد']);
        Permission::create(['name' => 'ویرایش صفت افراد']);
        Permission::create(['name' => 'نمایش جزئیات صفت افراد']);
        Permission::create(['name' => 'حذف صفت افراد']);
        Permission::create(['name' => 'دسترسی به منوی صفت افراد']);

        Permission::create(['name' => 'لیست موضوع چند رسانه ای']);
        Permission::create(['name' => 'ایجاد موضوع چند رسانه ای']);
        Permission::create(['name' => 'ویرایش موضوع چند رسانه ای']);
        Permission::create(['name' => 'نمایش جزئیات موضوع چند رسانه ای']);
        Permission::create(['name' => 'حذف موضوع چند رسانه ای']);
        Permission::create(['name' => 'دسترسی به منوی موضوع چند رسانه ای']);

        //Posts
        Permission::create(['name' => 'دسترسی به منوی پست ها']);

        Permission::create(['name' => 'لیست اسناد']);
        Permission::create(['name' => 'ایجاد اسناد']);
        Permission::create(['name' => 'ویرایش اسناد']);
        Permission::create(['name' => 'نمایش جزئیات اسناد']);
        Permission::create(['name' => 'حذف اسناد']);
        Permission::create(['name' => 'دسترسی به منوی اسناد']);

        Permission::create(['name' => 'لیست اسناد خارجی']);
        Permission::create(['name' => 'ایجاد اسناد خارجی']);
        Permission::create(['name' => 'ویرایش اسناد خارجی']);
        Permission::create(['name' => 'نمایش جزئیات اسناد خارجی']);
        Permission::create(['name' => 'حذف اسناد خارجی']);
        Permission::create(['name' => 'دسترسی به منوی اسناد خارجی']);

        Permission::create(['name' => 'لیست سوژه های پژوهشی']);
        Permission::create(['name' => 'ایجاد سوژه های پژوهشی']);
        Permission::create(['name' => 'ویرایش سوژه های پژوهشی']);
        Permission::create(['name' => 'نمایش جزئیات سوژه های پژوهشی']);
        Permission::create(['name' => 'حذف سوژه های پژوهشی']);
        Permission::create(['name' => 'دسترسی به منوی سوژه های پژوهشی']);


        Permission::create(['name' => 'لیست سوژه های رسانه ای']);
        Permission::create(['name' => 'ایجاد سوژه های رسانه ای']);
        Permission::create(['name' => 'ویرایش سوژه های رسانه ای']);
        Permission::create(['name' => 'نمایش جزئیات سوژه های رسانه ای']);
        Permission::create(['name' => 'حذف سوژه های رسانه ای']);
        Permission::create(['name' => 'دسترسی به منوی سوژه های رسانه ای']);

        Permission::create(['name' => 'لیست اساتید']);
        Permission::create(['name' => 'ایجاد اساتید']);
        Permission::create(['name' => 'ویرایش اساتید']);
        Permission::create(['name' => 'نمایش جزئیات اساتید']);
        Permission::create(['name' => 'حذف اساتید']);
        Permission::create(['name' => 'دسترسی به منوی اساتید']);

        Permission::create(['name' => 'لیست یادداشت ها']);
        Permission::create(['name' => 'ایجاد یادداشت ها']);
        Permission::create(['name' => 'ویرایش یادداشت ها']);
        Permission::create(['name' => 'نمایش جزئیات یادداشت ها']);
        Permission::create(['name' => 'حذف یادداشت ها']);
        Permission::create(['name' => 'دسترسی به منوی یادداشت ها']);

        Permission::create(['name' => 'لیست کلاس اسناد']);
        Permission::create(['name' => 'ایجاد کلاس اسناد']);
        Permission::create(['name' => 'ویرایش کلاس اسناد']);
        Permission::create(['name' => 'نمایش جزئیات کلاس اسناد']);
        Permission::create(['name' => 'حذف کلاس اسناد']);
        Permission::create(['name' => 'دسترسی به منوی کلاس اسناد']);

        Permission::create(['name' => 'لیست پرونده ویژه']);
        Permission::create(['name' => 'ایجاد پرونده ویژه']);
        Permission::create(['name' => 'ویرایش پرونده ویژه']);
        Permission::create(['name' => 'نمایش جزئیات پرونده ویژه']);
        Permission::create(['name' => 'حذف پرونده ویژه']);
        Permission::create(['name' => 'دسترسی به منوی پرونده ویژه']);

        //Multimedia
        Permission::create(['name' => 'لیست صوت ها']);
        Permission::create(['name' => 'ایجاد صوت ها']);
        Permission::create(['name' => 'ویرایش صوت ها']);
        Permission::create(['name' => 'نمایش جزئیات صوت ها']);
        Permission::create(['name' => 'حذف صوت ها']);

        Permission::create(['name' => 'لیست فیلم های کوتاه']);
        Permission::create(['name' => 'ایجاد فیلم های کوتاه']);
        Permission::create(['name' => 'ویرایش فیلم های کوتاه']);
        Permission::create(['name' => 'نمایش جزئیات فیلم های کوتاه']);
        Permission::create(['name' => 'حذف فیلم های کوتاه']);

        Permission::create(['name' => 'لیست آلبوم تصاویر']);
        Permission::create(['name' => 'ایجاد آلبوم تصاویر']);
        Permission::create(['name' => 'ویرایش آلبوم تصاویر']);
        Permission::create(['name' => 'نمایش جزئیات آلبوم تصاویر']);
        Permission::create(['name' => 'حذف آلبوم تصاویر']);

        Permission::create(['name' => 'دسترسی به منوی چند رسانه ای']);
        Permission::create(['name' => 'دسترسی به منوی صوت ها']);
        Permission::create(['name' => 'دسترسی به منوی فیلم های کوتاه']);
        Permission::create(['name' => 'دسترسی به منوی آلبوم تصاویر']);
        Permission::create(['name' => 'دسترسی به منوی فضای مجازی']);

        Permission::create(['name' => 'لیست مستند']);
        Permission::create(['name' => 'ایجاد مستند']);
        Permission::create(['name' => 'ویرایش مستند']);
        Permission::create(['name' => 'نمایش جزئیات مستند']);
        Permission::create(['name' => 'حذف مستند']);
        Permission::create(['name' => 'دسترسی به منوی مستند']);

        Permission::create(['name' => 'لیست فضای مجازی']);
        Permission::create(['name' => 'ایجاد فضای مجازی']);
        Permission::create(['name' => 'ویرایش فضای مجازی']);
        Permission::create(['name' => 'نمایش جزئیات فضای مجازی']);
        Permission::create(['name' => 'حذف فضای مجازی']);

        Permission::create(['name' => 'لیست معرفی کتاب']);
        Permission::create(['name' => 'ایجاد معرفی کتاب']);
        Permission::create(['name' => 'ویرایش معرفی کتاب']);
        Permission::create(['name' => 'نمایش جزئیات معرفی کتاب']);
        Permission::create(['name' => 'حذف معرفی کتاب']);
        Permission::create(['name' => 'دسترسی به منوی معرفی کتاب']);

        //Users Manager
        Permission::create(['name' => 'لیست کاربران']);
        Permission::create(['name' => 'ایجاد کاربر']);
        Permission::create(['name' => 'ویرایش کاربر']);
        Permission::create(['name' => 'تغییر وضعیت کاربر']);
        Permission::create(['name' => 'تغییر وضعیت نیازمند به تغییر رمز عبور']);
        Permission::create(['name' => 'بازنشانی رمز عبور کاربر']);
        Permission::create(['name' => 'جستجوی کاربر']);
        Permission::create(['name' => 'دسترسی به منوی مدیریت کاربران']);

        //Users Manager
        Permission::create(['name' => 'لیست بکاپ دیتابیس']);
        Permission::create(['name' => 'ایجاد بکاپ دیتابیس']);
        Permission::create(['name' => 'دسترسی به منوی بکاپ دیتابیس']);

        //Website settings
        Permission::create(['name' => 'دسترسی به منوی تنظیمات سایت']);
        Permission::create(['name' => 'لیست تنظیمات سایت']);
        Permission::create(['name' => 'ویرایش تنظیمات سایت']);

        Permission::create(['name' => 'telescope']);

        $superAdminRole = Role::create(['name' => 'ادمین کل']);
        $superAdminRole->givePermissionTo([
            'telescope',
            'لیست نقش ها',
            'ایجاد نقش',
            'ویرایش نقش',
            'نمایش جزئیات نقش',
            'حذف نقش',
            'لیست دسترسی ها',
            'ایجاد دسترسی',
            'ویرایش دسترسی',
            'نمایش جزئیات دسترسی',
            'حذف دسترسی',
            'لیست انواع سند',
            'ایجاد نوع سند',
            'ویرایش نوع سند',
            'نمایش جزئیات نوع سند',
            'حذف نوع سند',
            'لیست موضوعات صوت',
            'ایجاد موضوعات صوت',
            'ویرایش موضوعات صوت',
            'نمایش جزئیات موضوعات صوت',
            'حذف موضوعات صوت',
            'لیست قالب سوژه ها',
            'ایجاد قالب سوژه ها',
            'ویرایش قالب سوژه ها',
            'نمایش جزئیات قالب سوژه ها',
            'حذف قالب سوژه ها',
            'لیست مخاطب سوژه ها',
            'ایجاد مخاطب سوژه ها',
            'ویرایش مخاطب سوژه ها',
            'نمایش جزئیات مخاطب سوژه ها',
            'حذف مخاطب سوژه ها',
            'لیست مدرس دوره',
            'ایجاد مدرس دوره',
            'ویرایش مدرس دوره',
            'نمایش جزئیات مدرس دوره',
            'حذف مدرس دوره',
            'لیست صفت افراد',
            'ایجاد صفت افراد',
            'ویرایش صفت افراد',
            'نمایش جزئیات صفت افراد',
            'حذف صفت افراد',
            'لیست موضوع چند رسانه ای',
            'ایجاد موضوع چند رسانه ای',
            'ویرایش موضوع چند رسانه ای',
            'نمایش جزئیات موضوع چند رسانه ای',
            'حذف موضوع چند رسانه ای',
            'لیست اسناد',
            'ایجاد اسناد',
            'ویرایش اسناد',
            'نمایش جزئیات اسناد',
            'حذف اسناد',
            'لیست اسناد خارجی',
            'ایجاد اسناد خارجی',
            'ویرایش اسناد خارجی',
            'نمایش جزئیات اسناد خارجی',
            'حذف اسناد خارجی',
            'لیست سوژه های پژوهشی',
            'ایجاد سوژه های پژوهشی',
            'ویرایش سوژه های پژوهشی',
            'نمایش جزئیات سوژه های پژوهشی',
            'حذف سوژه های پژوهشی',
            'لیست سوژه های رسانه ای',
            'ایجاد سوژه های رسانه ای',
            'ویرایش سوژه های رسانه ای',
            'نمایش جزئیات سوژه های رسانه ای',
            'حذف سوژه های رسانه ای',
            'لیست اساتید',
            'ایجاد اساتید',
            'ویرایش اساتید',
            'نمایش جزئیات اساتید',
            'حذف اساتید',
            'لیست مستند',
            'ایجاد مستند',
            'ویرایش مستند',
            'نمایش جزئیات مستند',
            'حذف مستند',
            'لیست فضای مجازی',
            'ایجاد فضای مجازی',
            'ویرایش فضای مجازی',
            'نمایش جزئیات فضای مجازی',
            'حذف فضای مجازی',
            'لیست معرفی کتاب',
            'ایجاد معرفی کتاب',
            'ویرایش معرفی کتاب',
            'نمایش جزئیات معرفی کتاب',
            'حذف معرفی کتاب',
            'لیست یادداشت ها',
            'ایجاد یادداشت ها',
            'ویرایش یادداشت ها',
            'نمایش جزئیات یادداشت ها',
            'حذف یادداشت ها',
            'لیست صوت ها',
            'ایجاد صوت ها',
            'ویرایش صوت ها',
            'نمایش جزئیات صوت ها',
            'حذف صوت ها',
            'لیست فیلم های کوتاه',
            'ایجاد فیلم های کوتاه',
            'ویرایش فیلم های کوتاه',
            'نمایش جزئیات فیلم های کوتاه',
            'حذف فیلم های کوتاه',
            'لیست آلبوم تصاویر',
            'ایجاد آلبوم تصاویر',
            'ویرایش آلبوم تصاویر',
            'نمایش جزئیات آلبوم تصاویر',
            'حذف آلبوم تصاویر',
            'لیست کلاس اسناد',
            'ایجاد کلاس اسناد',
            'ویرایش کلاس اسناد',
            'نمایش جزئیات کلاس اسناد',
            'حذف کلاس اسناد',
            'لیست پرونده ویژه',
            'ایجاد پرونده ویژه',
            'ویرایش پرونده ویژه',
            'نمایش جزئیات پرونده ویژه',
            'حذف پرونده ویژه',
            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'جستجوی کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
            'دسترسی به منوی مقادیر اولیه',
            'دسترسی به منوی مدیریت کاربران',
            'دسترسی به منوی دسترسی ها',
            'دسترسی به منوی نقش های کاربری',
            'دسترسی به منوی بکاپ دیتابیس',
            'دسترسی به منوی انواع سند',
            'دسترسی به منوی اسناد',
            'دسترسی به منوی اسناد خارجی',
            'دسترسی به منوی سوژه های پژوهشی',
            'دسترسی به منوی سوژه های رسانه ای',
            'دسترسی به منوی اساتید',
            'دسترسی به منوی مستند',
            'دسترسی به منوی فضای مجازی',
            'دسترسی به منوی معرفی کتاب',
            'دسترسی به منوی پست ها',
            'دسترسی به منوی چند رسانه ای',
            'دسترسی به منوی صوت ها',
            'دسترسی به منوی فیلم های کوتاه',
            'دسترسی به منوی یادداشت ها',
            'دسترسی به منوی موضوعات صوت',
            'دسترسی به منوی آلبوم تصاویر',
            'دسترسی به منوی تنظیمات سایت',
            'دسترسی به منوی قالب سوژه ها',
            'دسترسی به منوی مخاطب سوژه ها',
            'دسترسی به منوی مدرس دوره',
            'دسترسی به منوی کلاس اسناد',
            'دسترسی به منوی صفت افراد',
            'دسترسی به منوی موضوع چند رسانه ای',
            'دسترسی به منوی پرونده ویژه',
            'لیست تنظیمات سایت',
            'ویرایش تنظیمات سایت',
        ]);

        $role = Role::where('name', 'ادمین کل')->first();
        $users = User::get();
        foreach ($users as $user) {
            $user = User::find($user->id);
            $user->assignRole([$role->id]);
        }
    }
}
