<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use DB;

class LoginController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //  dd(DB::connection()->getDatabaseName());
        return view('auth.login');
    }

    /**
     * Summary of login
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {

        $user = User::where('UserID', $request->user_id)->first();

        if ($user) {
            if (Hash::check($request->password, $user->Password)) {
                if (Auth::login($user)) {

                    // return redirect()->intended(RouteServiceProvider::HOME);
                    return redirect()->route('dashboard');
                }
            }
            return $this->error('login', 'You entered wrong password!');
        }

        return $this->error('login', 'User does not exists!');
    }

    public function login_new(Request $request)
    {

        // Validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        // If validation fails, redirect back with error messages
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard')->with('success', 'Welcome to your dashboard!');
        } else {
            // Authentication failed, redirect back with error message
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.')->withInput();
        }
    }

    /**
     * Summary of logout
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();

        return $this->success('login', 'You are successfully logged out!');
    }
}
