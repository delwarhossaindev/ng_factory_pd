<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{   
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {   
        return view('admin.user.profile');
    }
    
    /**
     * Summary of update
     * @param User $user
     * @param ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, ProfileUpdateRequest $request)
    {   
        $user->updateProfile($user, $request)
            ->saveAddress($request);
        
        return $this->success('profile',trans('sentence.profile_updated'));
    }
}
