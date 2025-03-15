<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('permission_role')->truncate();
        $permissions = Permission::all();

        foreach ($permissions as $key => $permission) {
            DB::table('permission_role')->insert([
                'permission_id' => $permission->id,
                'role_id'       => 1
            ]);
        }

        $permissions = Permission::find([2, 3, 4]);

        foreach ($permissions as $key => $permission) {
            DB::table('permission_role')->insert([
                'permission_id' => $permission->id,
                'role_id'       => 2
            ]);
        }
    }
}
