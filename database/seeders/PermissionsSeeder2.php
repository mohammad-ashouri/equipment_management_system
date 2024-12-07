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
            ['name' => 'لیست کولر گازی', 'guard_name' => 'web'],
            ['name' => 'ایجاد کولر گازی', 'guard_name' => 'web'],
            ['name' => 'ویرایش کولر گازی', 'guard_name' => 'web'],

            ['name' => 'لیست بخاری برقی', 'guard_name' => 'web'],
            ['name' => 'ایجاد بخاری برقی', 'guard_name' => 'web'],
            ['name' => 'ویرایش بخاری برقی', 'guard_name' => 'web'],

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
    }
}
