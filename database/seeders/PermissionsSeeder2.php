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
