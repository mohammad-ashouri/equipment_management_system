<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'لیست کولر آبی', 'guard_name' => 'web'],
            ['name' => 'ایجاد کولر آبی', 'guard_name' => 'web'],
            ['name' => 'ویرایش کولر آبی', 'guard_name' => 'web'],

            ['name' => 'لیست کولر گازی', 'guard_name' => 'web'],
            ['name' => 'ایجاد کولر گازی', 'guard_name' => 'web'],
            ['name' => 'ویرایش کولر گازی', 'guard_name' => 'web'],

            ['name' => 'لیست بخاری', 'guard_name' => 'web'],
            ['name' => 'ایجاد بخاری', 'guard_name' => 'web'],
            ['name' => 'ویرایش بخاری', 'guard_name' => 'web'],

            ['name' => 'لیست نردبان', 'guard_name' => 'web'],
            ['name' => 'ایجاد نردبان', 'guard_name' => 'web'],
            ['name' => 'ویرایش نردبان', 'guard_name' => 'web'],

            ['name' => 'لیست تلوزیون', 'guard_name' => 'web'],
            ['name' => 'ایجاد تلوزیون', 'guard_name' => 'web'],
            ['name' => 'ویرایش تلوزیون', 'guard_name' => 'web'],

            ['name' => 'لیست میز پینگ پنگ', 'guard_name' => 'web'],
            ['name' => 'ایجاد میز پینگ پنگ', 'guard_name' => 'web'],
            ['name' => 'ویرایش میز پینگ پنگ', 'guard_name' => 'web'],

            ['name' => 'لیست مایکروفر', 'guard_name' => 'web'],
            ['name' => 'ایجاد مایکروفر', 'guard_name' => 'web'],
            ['name' => 'ویرایش مایکروفر', 'guard_name' => 'web'],

            ['name' => 'لیست پنکه', 'guard_name' => 'web'],
            ['name' => 'ایجاد پنکه', 'guard_name' => 'web'],
            ['name' => 'ویرایش پنکه', 'guard_name' => 'web'],

            ['name' => 'لیست جاروبرقی', 'guard_name' => 'web'],
            ['name' => 'ایجاد جاروبرقی', 'guard_name' => 'web'],
            ['name' => 'ویرایش جاروبرقی', 'guard_name' => 'web'],

            ['name' => 'لیست جالباسی', 'guard_name' => 'web'],
            ['name' => 'ایجاد جالباسی', 'guard_name' => 'web'],
            ['name' => 'ویرایش جالباسی', 'guard_name' => 'web'],

            ['name' => 'لیست کاغذ خردکن', 'guard_name' => 'web'],
            ['name' => 'ایجاد کاغذ خردکن', 'guard_name' => 'web'],
            ['name' => 'ویرایش کاغذ خردکن', 'guard_name' => 'web'],

            ['name' => 'لیست اجاق', 'guard_name' => 'web'],
            ['name' => 'ایجاد اجاق', 'guard_name' => 'web'],
            ['name' => 'ویرایش اجاق', 'guard_name' => 'web'],

            ['name' => 'لیست تصفیه کننده آب', 'guard_name' => 'web'],
            ['name' => 'ایجاد تصفیه کننده آب', 'guard_name' => 'web'],
            ['name' => 'ویرایش تصفیه کننده آب', 'guard_name' => 'web'],

            ['name' => 'لیست چای ساز', 'guard_name' => 'web'],
            ['name' => 'ایجاد چای ساز', 'guard_name' => 'web'],
            ['name' => 'ویرایش چای ساز', 'guard_name' => 'web'],

            ['name' => 'لیست سماور', 'guard_name' => 'web'],
            ['name' => 'ایجاد سماور', 'guard_name' => 'web'],
            ['name' => 'ویرایش سماور', 'guard_name' => 'web'],

            ['name' => 'لیست تخته وایت بورد', 'guard_name' => 'web'],
            ['name' => 'ایجاد تخته وایت بورد', 'guard_name' => 'web'],
            ['name' => 'ویرایش تخته وایت بورد', 'guard_name' => 'web'],

            ['name' => 'لیست آبسردکن', 'guard_name' => 'web'],
            ['name' => 'ایجاد آبسردکن', 'guard_name' => 'web'],
            ['name' => 'ویرایش آبسردکن', 'guard_name' => 'web'],

            ['name' => 'لیست تخته اعلانات', 'guard_name' => 'web'],
            ['name' => 'ایجاد تخته اعلانات', 'guard_name' => 'web'],
            ['name' => 'ویرایش تخته اعلانات', 'guard_name' => 'web'],

            ['name' => 'لیست برش دهنده کاغذ', 'guard_name' => 'web'],
            ['name' => 'ایجاد برش دهنده کاغذ', 'guard_name' => 'web'],
            ['name' => 'ویرایش برش دهنده کاغذ', 'guard_name' => 'web'],

            ['name' => 'لیست فنرزن کاغذ', 'guard_name' => 'web'],
            ['name' => 'ایجاد فنرزن کاغذ', 'guard_name' => 'web'],
            ['name' => 'ویرایش فنرزن کاغذ', 'guard_name' => 'web'],

            ['name' => 'لیست دستگاه صحافی چسب گرم', 'guard_name' => 'web'],
            ['name' => 'ایجاد دستگاه صحافی چسب گرم', 'guard_name' => 'web'],
            ['name' => 'ویرایش دستگاه صحافی چسب گرم', 'guard_name' => 'web'],

            ['name' => 'لیست صندوق پیشنهادات', 'guard_name' => 'web'],
            ['name' => 'ایجاد صندوق پیشنهادات', 'guard_name' => 'web'],
            ['name' => 'ویرایش صندوق پیشنهادات', 'guard_name' => 'web'],

            ['name' => 'لیست کمد', 'guard_name' => 'web'],
            ['name' => 'ایجاد کمد', 'guard_name' => 'web'],
            ['name' => 'ویرایش کمد', 'guard_name' => 'web'],

            ['name' => 'لیست دستگاه سلفون کش و لمینیت', 'guard_name' => 'web'],
            ['name' => 'ایجاد دستگاه سلفون کش و لمینیت', 'guard_name' => 'web'],
            ['name' => 'ویرایش دستگاه سلفون کش و لمینیت', 'guard_name' => 'web'],

            ['name' => 'لیست کتابخانه', 'guard_name' => 'web'],
            ['name' => 'ایجاد کتابخانه', 'guard_name' => 'web'],
            ['name' => 'ویرایش کتابخانه', 'guard_name' => 'web'],

            ['name' => 'لیست تخت خواب', 'guard_name' => 'web'],
            ['name' => 'ایجاد تخت خواب', 'guard_name' => 'web'],
            ['name' => 'ویرایش تخت خواب', 'guard_name' => 'web'],

            ['name' => 'لیست جلومبلی/میز عسلی', 'guard_name' => 'web'],
            ['name' => 'ایجاد جلومبلی/میز عسلی', 'guard_name' => 'web'],
            ['name' => 'ویرایش جلومبلی/میز عسلی', 'guard_name' => 'web'],

            ['name' => 'لیست کتاب', 'guard_name' => 'web'],
            ['name' => 'ایجاد کتاب', 'guard_name' => 'web'],
            ['name' => 'ویرایش کتاب', 'guard_name' => 'web'],

            ['name' => 'لیست انتشارات', 'guard_name' => 'web'],
            ['name' => 'ایجاد انتشارات', 'guard_name' => 'web'],
            ['name' => 'ویرایش انتشارات', 'guard_name' => 'web'],

            ['name' => 'لیست موضوعات کتاب', 'guard_name' => 'web'],
            ['name' => 'ایجاد موضوعات کتاب', 'guard_name' => 'web'],
            ['name' => 'ویرایش موضوعات کتاب', 'guard_name' => 'web'],


            ['name' => 'لیست پایه تخته وایت بورد', 'guard_name' => 'web'],
            ['name' => 'ایجاد پایه تخته وایت بورد', 'guard_name' => 'web'],
            ['name' => 'ویرایش پایه تخته وایت بورد', 'guard_name' => 'web'],

            ['name' => 'لیست اقلام مصرفی', 'guard_name' => 'web'],
            ['name' => 'ایجاد اقلام مصرفی', 'guard_name' => 'web'],
            ['name' => 'ویرایش اقلام مصرفی', 'guard_name' => 'web'],
            ['name' => 'حذف اقلام مصرفی', 'guard_name' => 'web'],

            ['name' => 'لیست جاکفشی', 'guard_name' => 'web'],
            ['name' => 'ایجاد جاکفشی', 'guard_name' => 'web'],
            ['name' => 'ویرایش جاکفشی', 'guard_name' => 'web'],

            ['name' => 'لیست گاو صندوق', 'guard_name' => 'web'],
            ['name' => 'ایجاد گاو صندوق', 'guard_name' => 'web'],
            ['name' => 'ویرایش گاو صندوق', 'guard_name' => 'web'],

            ['name' => 'لیست تب سنج', 'guard_name' => 'web'],
            ['name' => 'ایجاد تب سنج', 'guard_name' => 'web'],
            ['name' => 'ویرایش تب سنج', 'guard_name' => 'web'],

            ['name' => 'لیست تابلو برق', 'guard_name' => 'web'],
            ['name' => 'ایجاد تابلو برق', 'guard_name' => 'web'],
            ['name' => 'ویرایش تابلو برق', 'guard_name' => 'web'],

            ['name' => 'لیست چراغ قوه', 'guard_name' => 'web'],
            ['name' => 'ایجاد چراغ قوه', 'guard_name' => 'web'],
            ['name' => 'ویرایش چراغ قوه', 'guard_name' => 'web'],

            ['name' => 'لیست محراب', 'guard_name' => 'web'],
            ['name' => 'ایجاد محراب', 'guard_name' => 'web'],
            ['name' => 'ویرایش محراب', 'guard_name' => 'web'],

            ['name' => 'لیست براکت', 'guard_name' => 'web'],
            ['name' => 'ایجاد براکت', 'guard_name' => 'web'],
            ['name' => 'ویرایش براکت', 'guard_name' => 'web'],

            ['name' => 'لیست استند گلدان', 'guard_name' => 'web'],
            ['name' => 'ایجاد استند گلدان', 'guard_name' => 'web'],
            ['name' => 'ویرایش استند گلدان', 'guard_name' => 'web'],

            ['name' => 'لیست مبلمان', 'guard_name' => 'web'],
            ['name' => 'ایجاد مبلمان', 'guard_name' => 'web'],
            ['name' => 'ویرایش مبلمان', 'guard_name' => 'web'],

            ['name' => 'لیست دستگاه بدنسازی', 'guard_name' => 'web'],

            ['name' => 'لیست کراس', 'guard_name' => 'web'],
            ['name' => 'ایجاد کراس', 'guard_name' => 'web'],
            ['name' => 'ویرایش کراس', 'guard_name' => 'web'],
        ];

        $arrayPermissionsForCheck=[];
        foreach ($permissions as $permission) {
            $arrayPermissionsForCheck[]=$permission['name'];
        }
        Permission::whereIn('name', $arrayPermissionsForCheck)->where('guard_name', 'web')->delete();

        Permission::insert($permissions);

        $role = Role::firstOrCreate(['name' => 'ادمین کل']);
        $role->givePermissionTo(Permission::whereIn('name', $arrayPermissionsForCheck)->where('guard_name', 'web')->get());

        $role = Role::firstOrCreate(['name' => 'کارشناس اداری']);
        $role->givePermissionTo(Permission::whereIn('name', $arrayPermissionsForCheck)->where('guard_name', 'web')->get());


        $permissions = [
            ['name' => 'لیست رم دوربین', 'guard_name' => 'web'],
            ['name' => 'ایجاد رم دوربین', 'guard_name' => 'web'],
            ['name' => 'ویرایش رم دوربین', 'guard_name' => 'web'],

            ['name' => 'لیست دستگاه سانترال', 'guard_name' => 'web'],
            ['name' => 'ایجاد دستگاه سانترال', 'guard_name' => 'web'],
            ['name' => 'ویرایش دستگاه سانترال', 'guard_name' => 'web'],

            ['name' => 'لیست سوییچ ماهواره', 'guard_name' => 'web'],
            ['name' => 'ایجاد سوییچ ماهواره', 'guard_name' => 'web'],
            ['name' => 'ویرایش سوییچ ماهواره', 'guard_name' => 'web'],

            ['name' => 'لیست nvr', 'guard_name' => 'web'],
            ['name' => 'ایجاد nvr', 'guard_name' => 'web'],
            ['name' => 'ویرایش nvr', 'guard_name' => 'web'],

            ['name' => 'لیست lmb', 'guard_name' => 'web'],
            ['name' => 'ایجاد lmb', 'guard_name' => 'web'],
            ['name' => 'ویرایش lmb', 'guard_name' => 'web'],

            ['name' => 'لیست گیرنده دیجیتال', 'guard_name' => 'web'],
            ['name' => 'ایجاد گیرنده دیجیتال', 'guard_name' => 'web'],
            ['name' => 'ویرایش گیرنده دیجیتال', 'guard_name' => 'web'],

            ['name' => 'لیست پایه نور', 'guard_name' => 'web'],
            ['name' => 'ایجاد پایه نور', 'guard_name' => 'web'],
            ['name' => 'ویرایش پایه نور', 'guard_name' => 'web'],

            ['name' => 'لیست کابینت باتری', 'guard_name' => 'web'],
            ['name' => 'ایجاد کابینت باتری', 'guard_name' => 'web'],
            ['name' => 'ویرایش کابینت باتری', 'guard_name' => 'web'],

            ['name' => 'لیست نور', 'guard_name' => 'web'],
            ['name' => 'ایجاد نور', 'guard_name' => 'web'],
            ['name' => 'ویرایش نور', 'guard_name' => 'web'],

            ['name' => 'لیست اسلایدر دوربین', 'guard_name' => 'web'],
            ['name' => 'ایجاد اسلایدر دوربین', 'guard_name' => 'web'],
            ['name' => 'ویرایش اسلایدر دوربین', 'guard_name' => 'web'],

            ['name' => 'لیست سرور', 'guard_name' => 'web'],
            ['name' => 'ایجاد سرور', 'guard_name' => 'web'],
            ['name' => 'ویرایش سرور', 'guard_name' => 'web'],

            ['name' => 'لیست Storage', 'guard_name' => 'web'],
            ['name' => 'ایجاد Storage', 'guard_name' => 'web'],
            ['name' => 'ویرایش Storage', 'guard_name' => 'web'],

            ['name' => 'لیست قلم نوری', 'guard_name' => 'web'],
            ['name' => 'ایجاد قلم نوری', 'guard_name' => 'web'],
            ['name' => 'ویرایش قلم نوری', 'guard_name' => 'web'],

            ['name' => 'لیست رایتر اکسترنال', 'guard_name' => 'web'],
            ['name' => 'ایجاد رایتر اکسترنال', 'guard_name' => 'web'],
            ['name' => 'ویرایش رایتر اکسترنال', 'guard_name' => 'web'],

            ['name' => 'لیست اقلام سخت افزاری', 'guard_name' => 'web'],
        ];
        $arrayPermissionsForCheck=[];
        foreach ($permissions as $permission) {
            $arrayPermissionsForCheck[]=$permission['name'];
        }
        Permission::whereIn('name', $arrayPermissionsForCheck)->where('guard_name', 'web')->delete();

        Permission::insert($permissions);

        $role = Role::firstOrCreate(['name' => 'ادمین کل']);
        $role->givePermissionTo(Permission::whereIn('name', $arrayPermissionsForCheck)->where('guard_name', 'web')->get());

        $role = Role::firstOrCreate(['name' => 'کارشناس فنی']);
        $role->givePermissionTo(Permission::whereIn('name', $arrayPermissionsForCheck)->where('guard_name', 'web')->get());
    }
}
