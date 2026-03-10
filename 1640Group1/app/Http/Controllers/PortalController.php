<?php

namespace App\Http\Controllers;

use app\Http\Controllers\Controller;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class PortalController
{
    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => ['required','email','unique:users'],
        //     'password' => ['required','password'],
        //     // 'remember' => ['nullable', 'boolean']
        // ]);

        // $key = $this->throttleKey($request);

        // if (RateLimiter::tooManyAttempts($key, 5)) {
        //     return back()->withErrors([
        //         'email' => 'Too many login attempts. Please try again in '.RateLimiter::availableIn($key).' seconds.'
        //     ])->onlyInput('email');
        // }

        // $credentials = $request->only('email','password');
        // $remember = (bool) $request->boolean('remember');

        // if (! auth()->attempt($credentials)) {
        //     RateLimiter::hit($key, 60);
        //     return back() ->withErrors([
        //         'email' => 'The provided credentials are incorrect.'
        //     ])->onlyInput('email');
        // }

        // RateLimiter::clear($key);

        // $request->session()->regenerate();

        // return redirect()->intended(route('home'));
        return view("admin.home");
    }

    // public function logout(Request $request){
    //     auth()->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect()->route('login.show');
    // }

    public function forgotPassword(){
        return view("portal.forgotPassword");
    }
    public function newPassword(){
        return view("portal.resetPassword");
    }

    protected function throttleKey(Request $request): string {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }
}
