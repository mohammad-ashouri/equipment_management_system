<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ContactUsPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'لیست ارتباط با ما']);
        Permission::create(['name' => 'ارتباط با ما - تغییر وضعیت']);
        Permission::create(['name' => 'ارتباط با ما - حذف']);

        $superAdminRole = Role::where('name', 'ادمین کل')->first();
        $superAdminRole->givePermissionTo([
            'ارتباط با ما',
            'ارتباط با ما - تغییر وضعیت',
            'ارتباط با ما - حذف',
        ]);

//        $role = Role::where('name', 'ادمین کل')->first();
//        $users = User::get();
//        foreach ($users as $user) {
//            $user = User::find($user->id);
//            $user->assignRole([$role->id]);
//        }
    }
}
