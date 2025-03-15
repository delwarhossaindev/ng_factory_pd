<?php

namespace App\Models;

use App\Helpers\Watcher;
use OwenIt\Auditing\Contracts\Auditable;
use Laratrust\Models\Permission as PermissionModel;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends PermissionModel implements Auditable
{
    use HasFactory, AuditableTrait, Watcher;

    public $guarded = [];

    /**
     * Summary of getPermission
     * @return mixed
     */
    public function getPermission()
    {
        return $this::orderBy('description')->get();
    }

    /**
     * Summary of savePermission
     * @param mixed $request
     * @return Permission
     */
    public function savePermission($request): self
    {
        $this->name         = $request->name;
        $this->display_name = $request->display_name;
        $this->description  = $request->description;
        $this->save();

        return $this;
    }

    /**
     * Summary of updatePerssion
     * @param mixed $permission
     * @param mixed $request
     * @return Permission
     */
    public function updatePerssion($permission, $request)
    {
        $permission->update([
            'name'         => $request->name,
            'display_name' => $request->display_name,
            'description'  => $request->description
        ]);

        return $this;
    }
}
