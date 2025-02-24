<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = Permission::pluck('id');

        $role = Role::create([
            'title' => 'مدیر کل',
            'slug' => sluggable_helper_function('مدیر کل'),
            'description' => 'دسترسی به همه قسمت های وبسایت',
        ]);
        $role->permissions()->attach($permissions);

        $user = User::create([
            'fullName' => 'admin',
            'email' => 'admin@admin.com',
            'jobTitle' => 'Laravel',
            'education' => 'baccalaureate',
            'nationalCode' => '1000000000',
            'mobile' => '09123456789',
            'email_verified_at'=>now(),
            'level' => 'creator',
            'password' => bcrypt('123456'),
        ]);




        $permissionHasRole=Permission::query()->pluck('name')->toArray();
        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => $user->id
        ]);

    }
}
