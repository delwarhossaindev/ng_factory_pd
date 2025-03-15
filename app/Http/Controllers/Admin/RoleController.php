<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Summary of index
     * @param Role $role
     * @param Request $request
     * @return mixed
     */
    public function index(Role $role, Request $request)
    {
        if ($request->ajax()) {
            return $this->table($role::query())
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => route('role.edit', $row->id),
                            'is_modal' => true,
                            'button_text' => 'Edit',
                            'is_able_to_see' => can_do('edit-role')
                        ],
                        'second_link' => [
                            'route' => route('role.destroy', $row->id),
                            'is_modal' => false,
                            'button_text' => 'Delete',
                            'is_able_to_see' => can_do('delete-role')
                        ],
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.role.index', [
            'permissions' => permission_list()
        ]);
    }

    /**
     * Summary of store
     * @param Role $role
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Role $role, RoleRequest $request)
    {
        $role->saveRole($request);

        return $this->success('role.index', trans('sentence.role_created'));
    }

    /**
     * Summary of edit
     * @param Role $role
     * @return mixed|string
     */
    public function edit(Role $role)
    {
        return view('admin.role.modal._edit', [
            'role' => $role,
            'permissions' => permission_list()
        ])->render();
    }

    /**
     * Summary of update
     * @param Role $role
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, RoleRequest $request)
    {
        return back()->withError('Not allowed in demo mode');

        if (!isAdministrator()) {
            return $this->error('role.index', 'Sorry, only administrator can update the role information!');
        }

        if ($role->name === 'Administrator') {
            return $this->error('role.index', 'Warning, Administrator role can not be edited or deleted!');
        }

        $role->updateRole($role, $request);

        return $this->success('role.index', trans('sentence.role_updated'));
    }

    /**
     * Summary of destroy
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        return back()->withError('Not allowed in demo mode');

        if (!isAdministrator()) {
            return $this->error('role.index', 'Sorry, only administrator can update the role information!');
        }

        if ($role->name === 'Administrator') {
            return $this->error('role.index', 'Warning, Administrator role can not be edited or deleted!');
        }

        $role->delete();

        return $this->success('role.index', trans('sentence.role_deleted'));
    }
}
