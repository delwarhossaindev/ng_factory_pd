<?php

namespace App\Models;

use App\Helpers\Watcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laratrust\Models\Role as RoleModel;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends RoleModel implements Auditable
{
    use HasFactory, AuditableTrait, Watcher;

    public $guarded = [];

    /**
     * Summary of getRole
     * @return mixed
     */
    public function getRole()
    {
        return $this::orderBy('name', 'asc')->get();
    }

    /**
     * Summary of saveRole
     * @param mixed $request
     * @return Role
     */
    public function saveRole($request): Role
    {
        DB::beginTransaction();
        try {
            $this->name         = $request->name;
            $this->display_name = $request->display_name;
            $this->description  = $request->description;
            $this->save();

            $request->has('permissions') &&
                $this->permissions()->sync($request->permissions);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Role Create failed :: ' . $e->getMessage());
        }
        DB::commit();

        return $this;
    }

    /**
     * Summary of updateRole
     * @param mixed $role
     * @param mixed $request
     * @return Role
     */
    public function updateRole($role, $request): Role
    {
        DB::beginTransaction();
        try {
            $role->name         = $request->name;
            $role->display_name = $request->display_name;
            $role->description  = $request->description;
            $role->save();

            $role->permissions()->sync($request->permissions);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Role Update failed :: ' . $e->getMessage());
        }
        DB::commit();

        return $this;
    }
}
