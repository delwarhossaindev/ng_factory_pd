<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\OtpRequest;
use Illuminate\Http\Request;

class TwoFactorAuthController extends Controller
{   
    /**
     * Summary of prepareTwoFactor
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prepareTwoFactor(Request $request)
    {
        $secret = $request->user()->createTwoFactorAuth();

        return view('auth.2fa.index', [
            'qr_code' => $secret->toQr(),
            'uri'     => $secret->toUri(),
            'string'  => $secret->toString(),
        ]);
    }

    /**
     * Summary of confirmTwoFactor
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmTwoFactor(OtpRequest $request)
    {
        if ($request->user()->confirmTwoFactorAuth($request->code)) {
            return $this->success('profile', '2-FA Authentication has been enabled successfully');
        }

        return back()->withError('Invalid code');
    }

    /**
     * Summary of disableTwoFactorAuth
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableTwoFactorAuth(Request $request)
    {
        $request->user()->disableTwoFactorAuth();

        return back()->withSuccess('2-FA Authentication has been disabled');
    }
}
