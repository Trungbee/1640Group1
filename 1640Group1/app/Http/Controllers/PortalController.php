<?php

namespace App\Http\Controllers;

use app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PortalController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required','min:5','max:20']
        ]);
        $request->session()->regenerate();
        $user = User::where('email','=', $request->email)->first();
        if ($user) {
            if (Hash::check($request -> password, $user->password)){
                $request->session()->put('loginId',$user->userId);
                if($user->role=="admin"){
                    return view('admin.home');
                }else{
                    if($user->favorite_animal==null){
                        return view('staff.authSetup');
                    }else{
                        return view('staff.home');
                    }
                }

            } else {
                return back() ->with('fail', 'Password not matches');
            }
        } else {
            return back() -> with('fail', 'This email is not registered.');
        }
    }

    public function forgotPassword(){
        return view("portal.forgotPassword");
    }
    public function newPassword(){
        return view("portal.resetPassword");
    }


}
