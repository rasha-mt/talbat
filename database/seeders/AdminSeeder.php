<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = Admin::firstOrCreate(
            ['name' => 'admin'],
            [
                'email'    => 'admin@admin.com',
                'password' => bcrypt('123456'),
            ]
        );

        $admin_role = Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'guard_name' => 'nova',
        ]);

        Permission::firstOrCreate([
            'name' => 'manage_tutorials',
        ], [
            'guard_name' => 'nova',
        ]);

        Permission::firstOrCreate([
            'name' => 'manage_setting',
        ], [
            'guard_name' => 'nova',
        ]);

        Permission::firstOrCreate([
            'name' => 'manage_restaurant',
        ], [
            'guard_name' => 'nova',
        ]);
        Permission::firstOrCreate([
            'name' => 'manage_client',
        ], [
            'guard_name' => 'nova',
        ]);

        Permission::firstOrCreate([
            'name' => 'manage_admin_panel_user',
        ], [
            'guard_name' => 'nova',
        ]);

        Permission::firstOrCreate([
            'name' => 'manage_roles_permissions',
        ], [
            'guard_name' => 'nova',
        ]);

        $admin_role->syncPermissions([
            'manage_tutorials',
            'manage_restaurant',
            'manage_client',
            'manage_setting',
            'manage_admin_panel_user',
            'manage_roles_permissions',
        ]);
        $admin->assignRole('admin');
    }
}
