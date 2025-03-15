<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Summary of index
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function index(User $user, Request $request)
    {
        if ($request->ajax()) {
            return $this->table($user->userList($request))
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => route('user.edit', $row->UserID),
                            'is_modal' => false,
                            'button_text' => 'Edit',
                            'is_able_to_see' => 'HQ',
                        ],
                        'fourth_link' => [
                            'route' => route('impersonate', $row->UserID),
                            'is_modal' => false,
                            'button_text' => 'Secret Login',
                            'is_able_to_see' => 'HQ',
                        ],
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.user.index', [
            'vuser' => User::userCountInformation(),
        ]);
    }

    /**
     * Summary of store
     * @param User $user
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $userData = [
                'UserID' => $request->UserID,
                'UserName' => $request->UserName,
                'Password' => bcrypt($request->Password),
                'SupervisorID' => $request->SupervisorID,
                'Level' => $request->Level,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($request->hasFile('ProfilePath')) {
                $profileImage = $request->file('ProfilePath');
                $profilePath = $profileImage->store('profiles', 'public');
                $userData['ProfilePath'] = $profilePath;
            }

            if ($request->hasFile('SignaturePath')) {
                $signatureImage = $request->file('SignaturePath');
                $signaturePath = $signatureImage->store('signatures', 'public');
                $userData['SignaturePath'] = $signaturePath;
            }

            DB::table('UserManager')->insert($userData);

            $menuList = $request->Menus;
            if(!empty($menuList)){
                foreach ($menuList as $m) {
                    DB::table('user_menus')->insert([
                        'user_id' => $request->UserID,
                        'menu_id' => $m,
                    ]);
                }

            }

            DB::commit();

            return $this->success('user.index', trans('sentence.user_created_message'));

        } catch (\Exception $e) {

            DB::rollBack();

            return $this->error('user.index', $e->getMessage());
        }
    }

    /**
     * Summary of create
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Summary of edit
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Summary of update
     * @param User $user
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_old(User $user, UserRequest $request)
    {
        DB::beginTransaction();

        try {
            // Update the user data
            $user->updateUser($user, $request);

            // Delete existing user menus
            DB::table('user_menus')
                ->where('user_id', $request->UserID)
                ->delete();

            // Insert new user menus
            $menuList = $request->Menus;
            foreach ($menuList as $m) {
                DB::table('user_menus')->insert([
                    'user_id' => $request->UserID,
                    'menu_id' => $m,
                ]);
            }

            // Commit the transaction
            DB::commit();

            return $this->success('user.index', trans('sentence.user_updated'));
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();

            return $this->error('user.index', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
{
    DB::beginTransaction();
    try {
        // Find the existing user record
        $user = DB::table('UserManager')->where('UserID', $id)->first();

        if (!$user) {
            return $this->error('user.index', 'User not found.');
        }

        // Prepare the updated user data
        $userData = [
            'UserName' => $request->UserName,
            'SupervisorID' => $request->SupervisorID,
            'Level' => $request->Level,
            'updated_at' => now(),
        ];

        // Update password if provided
        if ($request->filled('Password')) {
            $userData['Password'] = bcrypt($request->Password);
        }

        // Handle profile image update
        if ($request->hasFile('ProfilePath')) {
            $profileImage = $request->file('ProfilePath');
            $profilePath = $profileImage->store('profiles', 'public');
            $userData['ProfilePath'] = $profilePath;

            // Optionally, delete the old profile image if it exists
            if ($user->ProfilePath) {
                Storage::disk('public')->delete($user->ProfilePath);
            }
        }

        // Handle signature image update
        if ($request->hasFile('SignaturePath')) {
            $signatureImage = $request->file('SignaturePath');
            $signaturePath = $signatureImage->store('signatures', 'public');
            $userData['SignaturePath'] = $signaturePath;

            // Optionally, delete the old signature image if it exists
            if ($user->SignaturePath) {
                Storage::disk('public')->delete($user->SignaturePath);
            }
        }

        // Update the user record
        DB::table('UserManager')->where('UserID', $id)->update($userData);

        // Update user menus
        $menuList = $request->Menus;
        if (!empty($menuList)) {
            // First, delete existing menus for the user
            DB::table('user_menus')->where('user_id', $id)->delete();

            // Then, insert the updated menus
            foreach ($menuList as $m) {
                DB::table('user_menus')->insert([
                    'user_id' => $id,
                    'menu_id' => $m,
                ]);
            }
        }

        DB::commit();

        return $this->success('user.index', trans('sentence.user_updated_message'));

    } catch (\Exception $e) {
        DB::rollBack();

        return $this->error('user.index', $e->getMessage());
    }
}

    /**
     * Summary of restore
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        return $this->error('user.index', 'Not allowed');

        if ($user->roles[0]->name === 'Administrator') {
            return $this->error('user.index', 'Sorry, administrator can not be deleted');
        }

        $user->delete();

        return $this->success('user.index', 'User moved to trash successfully');
    }

    public function activity(User $user)
    {
        $user = $user->load('activity');

        return view('admin.user.show', compact('user'));
    }

    /**
     * Summary of restore
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(User $user)
    {
        $user->restore();

        return $this->success('user.index', 'User restored successfully!');
    }

    /**
     * Summary of forceDelete
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(User $user)
    {
        if ($user->roles[0]->name === 'Administrator') {
            return $this->error('user.index', 'Sorry, administrator can not be deleted');
        }

        $user->forceDelete();

        return $this->success('user.index', 'User permanently deleted successfully!');
    }
}
