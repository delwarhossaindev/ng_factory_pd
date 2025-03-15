<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;

class ImpersonateController extends Controller
{
    public function index(User $user)
    {
        session()->put('impersonate', $user->UserID);
        return redirect()->route('dashboard');
    }

    public function destroy()
    {
        session()->forget('impersonate');
        return redirect()->route('dashboard');
    }
}
