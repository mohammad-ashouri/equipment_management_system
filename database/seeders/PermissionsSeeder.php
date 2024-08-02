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
            ['name' => 'لیست مقادیر اولیه', 'guard_name' => 'web'],
            ['name' => 'لیست تجهیزات سخت افزاری', 'guard_name' => 'web'],
            ['name' => 'لیست تجهیزات پشتیبانی', 'guard_name' => 'web'],
            ['name' => 'لیست تجهیزات دیجیتال', 'guard_name' => 'web'],
            ['name' => 'لیست تجهیزات شبکه', 'guard_name' => 'web'],

            ['name' => 'لیست نقش', 'guard_name' => 'web'],
            ['name' => 'ایجاد نقش', 'guard_name' => 'web'],
            ['name' => 'ویرایش نقش', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات نقش', 'guard_name' => 'web'],
            ['name' => 'حذف نقش', 'guard_name' => 'web'],

            ['name' => 'لیست دسترسی', 'guard_name' => 'web'],
            ['name' => 'ایجاد دسترسی', 'guard_name' => 'web'],
            ['name' => 'ویرایش دسترسی', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات دسترسی', 'guard_name' => 'web'],
            ['name' => 'حذف دسترسی', 'guard_name' => 'web'],

            ['name' => 'لیست ساختمان', 'guard_name' => 'web'],
            ['name' => 'ایجاد ساختمان', 'guard_name' => 'web'],
            ['name' => 'ویرایش ساختمان', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات ساختمان', 'guard_name' => 'web'],
            ['name' => 'حذف ساختمان', 'guard_name' => 'web'],

            ['name' => 'لیست برند', 'guard_name' => 'web'],
            ['name' => 'ایجاد برند', 'guard_name' => 'web'],
            ['name' => 'ویرایش برند', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات برند', 'guard_name' => 'web'],
            ['name' => 'حذف برند', 'guard_name' => 'web'],

            ['name' => 'لیست مانیتور', 'guard_name' => 'web'],
            ['name' => 'ایجاد مانیتور', 'guard_name' => 'web'],
            ['name' => 'ویرایش مانیتور', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات مانیتور', 'guard_name' => 'web'],
            ['name' => 'حذف مانیتور', 'guard_name' => 'web'],

            ['name' => 'لیست کیس', 'guard_name' => 'web'],
            ['name' => 'ایجاد کیس', 'guard_name' => 'web'],
            ['name' => 'ویرایش کیس', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات کیس', 'guard_name' => 'web'],
            ['name' => 'حذف کیس', 'guard_name' => 'web'],

            ['name' => 'لیست پردازنده', 'guard_name' => 'web'],
            ['name' => 'ایجاد پردازنده', 'guard_name' => 'web'],
            ['name' => 'ویرایش پردازنده', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات پردازنده', 'guard_name' => 'web'],
            ['name' => 'حذف پردازنده', 'guard_name' => 'web'],

            ['name' => 'لیست مادربورد', 'guard_name' => 'web'],
            ['name' => 'ایجاد مادربورد', 'guard_name' => 'web'],
            ['name' => 'ویرایش مادربورد', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات مادربورد', 'guard_name' => 'web'],
            ['name' => 'حذف مادربورد', 'guard_name' => 'web'],

            ['name' => 'لیست منبع تغذیه', 'guard_name' => 'web'],
            ['name' => 'ایجاد منبع تغذیه', 'guard_name' => 'web'],
            ['name' => 'ویرایش منبع تغذیه', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات منبع تغذیه', 'guard_name' => 'web'],
            ['name' => 'حذف منبع تغذیه', 'guard_name' => 'web'],

            ['name' => 'لیست رم', 'guard_name' => 'web'],
            ['name' => 'ایجاد رم', 'guard_name' => 'web'],
            ['name' => 'ویرایش رم', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات رم', 'guard_name' => 'web'],
            ['name' => 'حذف رم', 'guard_name' => 'web'],

            ['name' => 'لیست کارت گرافیک', 'guard_name' => 'web'],
            ['name' => 'ایجاد کارت گرافیک', 'guard_name' => 'web'],
            ['name' => 'ویرایش کارت گرافیک', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات کارت گرافیک', 'guard_name' => 'web'],
            ['name' => 'حذف کارت گرافیک', 'guard_name' => 'web'],

            ['name' => 'لیست هارد اینترنال', 'guard_name' => 'web'],
            ['name' => 'ایجاد هارد اینترنال', 'guard_name' => 'web'],
            ['name' => 'ویرایش هارد اینترنال', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات هارد اینترنال', 'guard_name' => 'web'],
            ['name' => 'حذف هارد اینترنال', 'guard_name' => 'web'],

            ['name' => 'لیست درایو نوری', 'guard_name' => 'web'],
            ['name' => 'ایجاد درایو نوری', 'guard_name' => 'web'],
            ['name' => 'ویرایش درایو نوری', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات درایو نوری', 'guard_name' => 'web'],
            ['name' => 'حذف درایو نوری', 'guard_name' => 'web'],

            ['name' => 'لیست موس', 'guard_name' => 'web'],
            ['name' => 'ایجاد موس', 'guard_name' => 'web'],
            ['name' => 'ویرایش موس', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات موس', 'guard_name' => 'web'],
            ['name' => 'حذف موس', 'guard_name' => 'web'],

            ['name' => 'لیست کارت شبکه', 'guard_name' => 'web'],
            ['name' => 'ایجاد کارت شبکه', 'guard_name' => 'web'],
            ['name' => 'ویرایش کارت شبکه', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات کارت شبکه', 'guard_name' => 'web'],
            ['name' => 'حذف کارت شبکه', 'guard_name' => 'web'],

            // Users Manager
            ['name' => 'لیست کاربران', 'guard_name' => 'web'],
            ['name' => 'ایجاد کاربر', 'guard_name' => 'web'],
            ['name' => 'ویرایش کاربر', 'guard_name' => 'web'],
            ['name' => 'تغییر وضعیت کاربر', 'guard_name' => 'web'],
            ['name' => 'تغییر وضعیت نیازمند به تغییر رمز عبور', 'guard_name' => 'web'],
            ['name' => 'بازنشانی رمز عبور کاربر', 'guard_name' => 'web'],
            ['name' => 'جستجوی کاربر', 'guard_name' => 'web'],

            // Database Backup
            ['name' => 'لیست بکاپ دیتابیس', 'guard_name' => 'web'],
            ['name' => 'ایجاد بکاپ دیتابیس', 'guard_name' => 'web'],

            ['name' => 'telescope', 'guard_name' => 'web']
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

            'لیست پردازنده',
            'ایجاد پردازنده',
            'ویرایش پردازنده',
            'نمایش جزئیات پردازنده',
            'حذف پردازنده',

            'لیست مادربورد',
            'ایجاد مادربورد',
            'ویرایش مادربورد',
            'نمایش جزئیات مادربورد',
            'حذف مادربورد',

            'لیست منبع تغذیه',
            'ایجاد منبع تغذیه',
            'ویرایش منبع تغذیه',
            'نمایش جزئیات منبع تغذیه',
            'حذف منبع تغذیه',

            'لیست رم',
            'ایجاد رم',
            'ویرایش رم',
            'نمایش جزئیات رم',
            'حذف رم',

            'لیست کارت گرافیک',
            'ایجاد کارت گرافیک',
            'ویرایش کارت گرافیک',
            'نمایش جزئیات کارت گرافیک',
            'حذف کارت گرافیک',

            'لیست هارد اینترنال',
            'ایجاد هارد اینترنال',
            'ویرایش هارد اینترنال',
            'نمایش جزئیات هارد اینترنال',
            'حذف هارد اینترنال',

            'لیست درایو نوری',
            'ایجاد درایو نوری',
            'ویرایش درایو نوری',
            'نمایش جزئیات درایو نوری',
            'حذف درایو نوری',

            'لیست موس',
            'ایجاد موس',
            'ویرایش موس',
            'نمایش جزئیات موس',
            'حذف موس',

            'لیست کارت شبکه',
            'ایجاد کارت شبکه',
            'ویرایش کارت شبکه',
            'نمایش جزئیات کارت شبکه',
            'حذف کارت شبکه',

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
            $user = User::findOrFail($user->id);
            $user->assignRole([$role->id]);
        }
    }
}
