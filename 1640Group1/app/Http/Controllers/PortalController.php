<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    public function showLogin(){
        return view('portal.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required','min:5','max:20']
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Check Password
            if (Hash::check($request->password, $user->passwordHash)) {

                // Login
                Auth::login($user, $request->has('remember'));

                // Refresh session
                $request->session()->regenerate();
                $request->session()->put('loginId', $user->userId);

                // Role-based redirection handling
                $role = strtolower($user->role);

                if ($role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'));
                }

                // Check Sercurity Question for Staff
                if (empty($user->favorite_animal)) {
                    return redirect()->route('staff.authSetup');
                }

                if ($role === 'staff'){
                    return redirect()->intended(route('staff.home'));
                }else if ($role === 'qamanager'){
                    return redirect()->intended(route('qa_manager.home'));
                }else if ($role === 'qacoordinator'){
                    return redirect()->intended(route('qa_coordinator.home'));
                }


            } else {
                return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
            }
        } else {
            return back()->withErrors(['email' => 'This email is not registered.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginPage');
    }

    public function showForgotPassword(){
        return view("portal.forgotPassword");
    }

    public function verifyQuestion(Request $request){
        $request->validate([
            'email' => ['required','email'],
            'security_question' => ['required','in:favorite_animal,favorite_color,child_birth_year'],
            'answer' => ['required']
        ]);

        $user = User::where('email','=',$request->email)->first();

        if(!$user){
            return back()->with('error','Email not found');
        }

        // Compare security questions
        $userAnswer = trim($user->{$request->security_question});
        if(trim($request->answer) === $userAnswer){
            session()->put('password_reset_user', $user->userId);
            return redirect(route('newPassword'));
        }

        return back()->with('error','The security answer is incorrect.');
    }

    public function newPassword(){
        if(!session()->has('password_reset_user')){
            return redirect()->route('forgotPassword')->with('error','The reset session has expired.');
        }
        return view('portal.resetPassword');
    }

    public function resetPassword(Request $request){
        $request->validate([
            'newPassword'=>'required|min:5',
            'verifyPassword'=>'required|same:newPassword'
        ]);

        $userId = session()->get('password_reset_user');
        $user = User::find($userId);

        if(!$user){
            return redirect()->route('forgotPassword')->with('error','User not found');
        }

        $user->passwordHash = Hash::make($request->newPassword);
        $user->save();

        session()->forget('password_reset_user');

        return redirect()->route('loginPage')->with('success','Password changed successfully. Please log in again.');
    }
}
