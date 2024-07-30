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
        // Preparing the array of permissions
        $permissions = [
            ['name' => 'لیست مقادیر اولیه','guard_name' => 'web'],
            ['name' => 'لیست تجهیزات سخت افزاری','guard_name' => 'web'],
            ['name' => 'لیست تجهیزات پشتیبانی','guard_name' => 'web'],
            ['name' => 'لیست تجهیزات دیجیتال','guard_name' => 'web'],
            ['name' => 'لیست تجهیزات شبکه','guard_name' => 'web'],

            ['name' => 'لیست نقش','guard_name' => 'web'],
            ['name' => 'ایجاد نقش','guard_name' => 'web'],
            ['name' => 'ویرایش نقش','guard_name' => 'web'],
            ['name' => 'نمایش جزئیات نقش','guard_name' => 'web'],
            ['name' => 'حذف نقش','guard_name' => 'web'],

            ['name' => 'لیست دسترسی','guard_name' => 'web'],
            ['name' => 'ایجاد دسترسی','guard_name' => 'web'],
            ['name' => 'ویرایش دسترسی','guard_name' => 'web'],
            ['name' => 'نمایش جزئیات دسترسی','guard_name' => 'web'],
            ['name' => 'حذف دسترسی','guard_name' => 'web'],

            ['name' => 'لیست ساختمان','guard_name' => 'web'],
            ['name' => 'ایجاد ساختمان','guard_name' => 'web'],
            ['name' => 'ویرایش ساختمان','guard_name' => 'web'],
            ['name' => 'نمایش جزئیات ساختمان','guard_name' => 'web'],
            ['name' => 'حذف ساختمان','guard_name' => 'web'],

            ['name' => 'لیست برند','guard_name' => 'web'],
            ['name' => 'ایجاد برند','guard_name' => 'web'],
            ['name' => 'ویرایش برند','guard_name' => 'web'],
            ['name' => 'نمایش جزئیات برند','guard_name' => 'web'],
            ['name' => 'حذف برند','guard_name' => 'web'],

            ['name' => 'لیست مانیتور','guard_name' => 'web'],
            ['name' => 'ایجاد مانیتور','guard_name' => 'web'],
            ['name' => 'ویرایش مانیتور','guard_name' => 'web'],
            ['name' => 'نمایش جزئیات مانیتور','guard_name' => 'web'],
            ['name' => 'حذف مانیتور','guard_name' => 'web'],

            ['name' => 'لیست کیس','guard_name' => 'web'],
            ['name' => 'ایجاد کیس','guard_name' => 'web'],
            ['name' => 'ویرایش کیس','guard_name' => 'web'],
            ['name' => 'نمایش جزئیات کیس','guard_name' => 'web'],
            ['name' => 'حذف کیس','guard_name' => 'web'],

            // Users Manager
            ['name' => 'لیست کاربران','guard_name' => 'web'],
            ['name' => 'ایجاد کاربر','guard_name' => 'web'],
            ['name' => 'ویرایش کاربر','guard_name' => 'web'],
            ['name' => 'تغییر وضعیت کاربر','guard_name' => 'web'],
            ['name' => 'تغییر وضعیت نیازمند به تغییر رمز عبور','guard_name' => 'web'],
            ['name' => 'بازنشانی رمز عبور کاربر','guard_name' => 'web'],
            ['name' => 'جستجوی کاربر','guard_name' => 'web'],

            // Database Backup
            ['name' => 'لیست بکاپ دیتابیس','guard_name' => 'web'],
            ['name' => 'ایجاد بکاپ دیتابیس','guard_name' => 'web'],

            ['name' => 'telescope','guard_name' => 'web']
        ];

        // Inserting the permissions into the database
        Permission::insert($permissions);

        $superAdminRole = Role::create(['name' => 'ادمین کل']);
        $superAdminRole->givePermissionTo([
            'telescope',
            'لیست مقادیر اولیه',
            'لیست تجهیزات پشتیبانی',
            'لیست تجهیزات سخت افزاری',
            'لیست تجهیزات دیجیتال',
            'لیست تجهیزات شبکه',

            'لیست نقش',
            'ایجاد نقش',
            'ویرایش نقش',
            'نمایش جزئیات نقش',
            'حذف نقش',

            'لیست دسترسی',
            'ایجاد دسترسی',
            'ویرایش دسترسی',
            'نمایش جزئیات دسترسی',
            'حذف دسترسی',

            'لیست ساختمان',
            'ایجاد ساختمان',
            'ویرایش ساختمان',
            'نمایش جزئیات ساختمان',
            'حذف ساختمان',

            'لیست برند',
            'ایجاد برند',
            'ویرایش برند',
            'نمایش جزئیات برند',
            'حذف برند',

            'لیست مانیتور',
            'ایجاد مانیتور',
            'ویرایش مانیتور',
            'نمایش جزئیات مانیتور',
            'حذف مانیتور',

            'لیست کیس',
            'ایجاد کیس',
            'ویرایش کیس',
            'نمایش جزئیات کیس',
            'حذف کیس',

            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'جستجوی کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
        ]);

        $role = Role::where('name', 'ادمین کل')->first();
        $users = User::get();
        foreach ($users as $user) {
            $user = User::find($user->id);
            $user->assignRole([$role->id]);
        }
    }
}
