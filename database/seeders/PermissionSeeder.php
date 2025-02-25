<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public $ordering = 1;
    public $ids = [];
    public function run(): void
    {

        $permissions = [
            'dashboards' => [
                'title'  => 'نمایش داشبورد',
                'values' => [
                    'index' => 'نمایش داشبورد',
                ]
            ],

            'users' => [
                'title'  => 'مدیریت کاربران',
                'values' => [
                    'index'  => 'لیست کاربران',
                    'create' => 'ایجاد کاربر',
                    'update' => 'ویرایش کاربر',
                    'show'   => 'مشاهده کاربر',
                    'role'   => 'تعریف مقام',
                    'delete' => 'حذف کاربر',
                ]
            ],

            'roles' => [
                'title'  => 'مدیریت مقام ها',
                'values' => [
                    'index'  => 'لیست مقام ها',
                    'create' => 'ایجاد مقام',
                    'update' => 'ویرایش مقام',
                    'delete' => 'حذف مقام',
                ]
            ],

            'committees' => [
                'title'  => 'مدیریت کمیته‌ها',
                'values' => [
                    'index'  => 'لیست کمیته‌ها',
                    'create' => 'ایجاد کمیته',
                    'update' => 'ویرایش کمیته',
                    'delete' => 'حذف کمیته',
                    'category' => 'دسته بندی',
                ]
            ],

            'members' => [
                'title'  => 'مدیریت اعضا',
                'values' => [
                    'index'  => 'لیست اعضا',
                    'create' => 'افزودن عضو',
                    'update' => 'ویرایش عضو',
                    'delete' => 'حذف عضو',
                    'category' => 'دسته بندی',
                ]
            ],

            'permissions' => [
                'title'  => 'مدیریت مجوزها',
                'values' => [
                    'index'  => 'لیست مجوزها',
                    'update' => 'ویرایش مجوز',
                ]
            ],

            'posts' => [
                'title'  => 'مدیریت پست‌ها',
                'values' => [
                    'index'  => 'لیست پست‌ها',
                    'create' => 'ایجاد پست',
                    'update' => 'ویرایش پست',
                    'delete' => 'حذف پست',
                    'category' => 'دسته بندی',
                ]
            ],

            'categories' => [
                'title'  => 'مدیریت دسته‌بندی‌ها',
                'values' => [
                    'index'  => 'لیست دسته‌بندی‌ها',
                    'create' => 'ایجاد دسته‌بندی',
                    'update' => 'ویرایش دسته‌بندی',
                    'delete' => 'حذف دسته‌بندی',
                ]
            ],

            'provinces' => [
                'title'  => 'مدیریت استان‌ها',
                'values' => [
                    'index'  => 'لیست استان‌ها',
                    'create' => 'ایجاد استان',
                    'update' => 'ویرایش استان',
                    'delete' => 'حذف استان',
                ]
            ],

            'regions' => [
                'title'  => 'مدیریت مناطق',
                'values' => [
                    'index'  => 'لیست مناطق',
                    'create' => 'ایجاد منطقه',
                    'update' => 'ویرایش منطقه',
                    'delete' => 'حذف منطقه',
                ]
            ],
        ];

        foreach ($permissions as $name => $value) {
            $this->create($name, $value);
        }

        Permission::whereNotIn('id', $this->ids)->delete();
    }
    private function create($name, $value, $permission_id = null)
    {
        if (is_array($value)) {

            $permission = Permission::updateOrCreate(
                [
                    'name' => $name
                ],
                [
                    'title'         => $value['title'],
                    'ordering'      => $this->ordering++,
                    'permission_id' => $permission_id
                ]
            );

            $this->ids[] = $permission->id;

            foreach ($value['values'] as $n => $val) {
                $this->create($name . '.' . $n, $val, $permission->id);
            }
        } else {
            $permission = Permission::updateOrCreate(
                [
                    'name' => $name
                ],
                [
                    'title'         => $value,
                    'ordering'      => $this->ordering++,
                    'permission_id' => $permission_id
                ]
            );

            $this->ids[] = $permission->id;
        }
    }


}
