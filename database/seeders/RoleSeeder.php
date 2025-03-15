<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::truncate();
        // DB::table('role_user')->truncate();

        $roles = [
            [
                'name' => 'Administrator',
                'display_name' => 'Admin',
                'description' => 'Can access all features!'
            ],
            [
                'name' => 'Publisher',
                'display_name' => 'Publisher',
                'description' => 'Can access limited features!'
            ]
        ];

        Role::insert($roles);
        $roleAdmin = Role::find(1);
        $rolePublisher = Role::find(2);
        User::first()->addRole($roleAdmin);

        foreach (User::skip(1)->take(15)->get() as $user) {
            $user->addRole($rolePublisher);
        }
    }
}
