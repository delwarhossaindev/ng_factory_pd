<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyOtpController extends Controller
{   
   /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @param Otp $otp
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Otp $otp, Request $request)
    {
        return view('auth.password.verify_otp', compact('otp'));
    }
    
    /**
     * Summary of store
     * @param Otp $otp
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Otp $otp)
    {
        if ($otp->hasExpired()) {
            return back()->withError('Your OTP has been expired.');
        }

        $requestedOtp = implode('', $request->otp);
        if ($requestedOtp === $otp->otp) {
            session()->put('user_requested_with_otp', $otp->id);
            return redirect()->route('reset.password', $otp->id);
        }
        
        return back()->withError('Otp does not matched');
    }
}
