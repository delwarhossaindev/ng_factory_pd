<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;

class ResetPasswordController extends Controller
{   
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Otp $otp)
    {
        return view('auth.password.reset_password', compact('otp'));
    }

    /**
     * Summary of store
     * @param User $user
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ForgotPasswordRequest $request, Otp  $otp)
    {
        $otp->user->update([
            'password' => bcrypt($request->password)
        ]);
        session()->forget('user_requested_with_otp');
        session()->forget('user_requested_reset_password_link');

        return $this->success('login', 'Password has been updated');
    }
}
