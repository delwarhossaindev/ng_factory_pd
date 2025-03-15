<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    /**
     * Summary of index
     * @param Permission $permission
     * @param Request $request
     * @return mixed
     */
    public function index(Permission $permission, Request $request)
    {
        dd(Permission::get());
        if ($request->ajax()) {
            dd(Permission::get());
            return $this->table(Permission::get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => route('permission.edit', $row->id),
                            'is_modal' => true,
                            'button_text' => 'Edit',
                            'is_able_to_see' => can_do('edit-permission')
                        ],
                        'second_link' => [
                            'route' => route('permission.destroy', $row->id),
                            'is_modal' => false,
                            'button_text' => 'Delete',
                            'is_able_to_see' => can_do('delete-permission')
                        ],
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.permission.index');
    }

    /**
     * Summary of store
     * @param Permission $permission
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Permission $permission, PermissionRequest $request)
    {
        return back()->withError('Not allowed in demo mode');

        $permission->savePermission($request);

        return $this->success('permission.index', trans('sentence.permission_created'));
    }

    /**
     * Summary of edit
     * @param Permission $permission
     * @return mixed|string
     */
    public function edit(Permission $permission)
    {
        return view('admin.permission.modal._edit', compact('permission'))->render();
    }

    /**
     * Summary of update
     * @param Permission $permission
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Permission $permission, PermissionRequest $request)
    {
        return back()->withError('Not allowed in demo mode');

        $permission->updatePerssion($permission, $request);

        return $this->success('permission.index', trans('sentence.permission_updated'));
    }

    /**
     * Summary of delete
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Permission $permission)
    {
        return back()->withError('Not allowed in demo mode');

        $permission->delete();

        return $this->success('permission.index', trans('sentence.permission_deleted'));
    }
}
