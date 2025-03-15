<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::truncate();
        // DB::table('permission_user')->truncate();

        $permissons = [
            //user
            [
                'name' => 'create-user',
                'display_name' => 'edit',
                'description' => 'user'
            ],
            [
                'name' => 'edit-user',
                'display_name' => 'create',
                'description' => 'user'
            ],
            [
                'name' => 'view-user',
                'display_name' => 'delete',
                'description' => 'user'
            ],
            [
                'name' => 'delete-user',
                'display_name' => 'view',
                'description' => 'user'
            ],
            [
                'name' => 'secret-login',
                'display_name' => 'impersonate',
                'description' => 'user'
            ],
            //post
            [
                'name' => 'create-article',
                'display_name' => 'edit',
                'description' => 'article'
            ],
            [
                'name' => 'edit-article',
                'display_name' => 'create',
                'description' => 'article'
            ],
            [
                'name' => 'view-article',
                'display_name' => 'delete',
                'description' => 'article'
            ],
            [
                'name' => 'delete-article',
                'display_name' => 'view',
                'description' => 'article'
            ],
            //category
            [
                'name' => 'create-category',
                'display_name' => 'edit',
                'description' => 'category'
            ],
            [
                'name' => 'edit-category',
                'display_name' => 'create',
                'description' => 'category'
            ],
            [
                'name' => 'view-category',
                'display_name' => 'delete',
                'description' => 'category'
            ],
            [
                'name' => 'delete-category',
                'display_name' => 'view',
                'description' => 'category'
            ],
            //page
            [
                'name' => 'create-page',
                'display_name' => 'edit',
                'description' => 'page'
            ],
            [
                'name' => 'edit-page',
                'display_name' => 'create',
                'description' => 'page'
            ],
            [
                'name' => 'view-page',
                'display_name' => 'delete',
                'description' => 'page'
            ],
            [
                'name' => 'delete-page',
                'display_name' => 'view',
                'description' => 'page'
            ],
            //tag
            [
                'name' => 'create-tag',
                'display_name' => 'edit',
                'description' => 'tag'
            ],
            [
                'name' => 'edit-tag',
                'display_name' => 'create',
                'description' => 'tag'
            ],
            [
                'name' => 'view-tag',
                'display_name' => 'delete',
                'description' => 'tag'
            ],
            [
                'name' => 'delete-tag',
                'display_name' => 'view',
                'description' => 'tag'
            ],
            //role
            [
                'name' => 'create-role',
                'display_name' => 'edit',
                'description' => 'role'
            ],
            [
                'name' => 'edit-role',
                'display_name' => 'create',
                'description' => 'role'
            ],
            [
                'name' => 'view-role',
                'display_name' => 'delete',
                'description' => 'role'
            ],
            [
                'name' => 'delete-role',
                'display_name' => 'view',
                'description' => 'role'
            ],
            //permission
            [
                'name' => 'create-permission',
                'display_name' => 'edit',
                'description' => 'permission'
            ],
            [
                'name' => 'edit-permission',
                'display_name' => 'create',
                'description' => 'permission'
            ],
            [
                'name' => 'view-permission',
                'display_name' => 'delete',
                'description' => 'permission'
            ],
            [
                'name' => 'delete-permission',
                'display_name' => 'view',
                'description' => 'permission'
            ],
        ];

        foreach ($permissons as $key => $value) {
            $permission = Permission::create([
                'name' => $value['name'],
                'display_name' => $value['display_name'],
                'description' => $value['description']
            ]);
            User::first()->givePermission($permission);
        }
    }
}
