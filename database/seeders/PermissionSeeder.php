<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'committees',
            'members',
            'permissions',
            'posts',
            'categories',
            'provinces',
            'regions',
            'roles',
            'users',
        ];

// لیست عملیات‌ها
        $actions = ['view', 'create', 'update', 'delete'];

// ایجاد مجوزها
        foreach ($modules as $module) {
            Permission::firstOrCreate(['name' => $module]);

            foreach ($actions as $action) {
                $permissionName = "{$action}-{$module}";
                Permission::firstOrCreate(['name' => $permissionName]);
            }
        }

// ایجاد نقش admin+
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

// اختصاص تمام مجوزها به نقش admin
        $permissions = Permission::pluck('name')->toArray(); // دریافت تمام مجوزها
        $adminRole->syncPermissions($permissions);

      /* $user = User::where('email', 'almasi.fanweb@gmail.com')->first();
        $user->assignRole($adminRole);*/

        // ایجاد یا یافتن نقش writer
        $writerRole = Role::firstOrCreate(['name' => 'writer']);

// لیست مجوزهای مربوط به posts و categories
        $allowedPermissions = [
            'posts',
            'view-posts',
            'create-posts',
            'update-posts',
            'delete-posts',
            'categories',
            'view-categories',
            'create-categories',
            'update-categories',
            'delete-categories',
        ];
        foreach ($allowedPermissions as $permissionName) {
            // ایجاد یا یافتن مجوز
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            // اختصاص مجوز به نقش writer
            $writerRole->givePermissionTo($permission);
        }



    }
}
