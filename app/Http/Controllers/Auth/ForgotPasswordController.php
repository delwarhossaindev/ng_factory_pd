<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Events\UserRequestedOtpCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;

class ForgotPasswordController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('auth.password.forgot_password');
    }

    /**
     * Summary of store
     * @param User $user
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ResetPasswordRequest $request, User  $user)
    {
        $user = $user->whereEmail($request->email)->first();

        event(new UserRequestedOtpCode($user));
        session()->put('user_requested_reset_password_link', $user->confirmationOtp->id);

        return redirect()->route('verify.otp', $user->confirmationOtp->id);
    }

    /**
     * Summary of resend
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(User $user)
    {
        event(new UserRequestedOtpCode($user));

        return redirect()->route('verify.otp', $user->confirmationOtp->id);
    }
}
