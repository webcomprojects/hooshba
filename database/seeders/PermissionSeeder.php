<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
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
            'provinces',
            'regions',
            'roles',
            'users',
        ];

// لیست عملیات‌ها
        $actions = ['view', 'create', 'update', 'delete'];

// ایجاد مجوزها
        foreach ($modules as $module) {
            // ایجاد مجوز اصلی برای ماژول (مانند "categories")
            Permission::firstOrCreate(['name' => $module]);

            // ایجاد مجوزهای فرعی برای ماژول (مانند "view-categories")
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
    }
}
