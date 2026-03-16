<?php

namespace App\Http\Controllers;

use app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PortalController
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
        $request->session()->regenerate();
        $user = User::where('email','=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)){
                $request->session()->put('loginId',$user->userId);
                if($user->role=="admin"){
                    return redirect('/admin/dashboard');
                }else{
                    if($user->favorite_animal==null){
                        return redirect('/staff/authSetup');
                    }else{
                        return redirect('/staff/home');
                    }
                }

            } else {
                return back() ->with('fail', 'Password not matches');
            }
        } else {
            return back() -> with('fail', 'This email is not registered.');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('loginId');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
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
            return back()->with('error','Không tìm thấy email');
        }

        if ($request->security_question=="favorite_animal"){
            if(trim($request->answer)==trim($user->favorite_animal)){
                session()->put('password_reset_user',$user->userId);
                return redirect(route('newPassword'));
            }
        }else if ($request->security_question=="favorite_color"){
            if(trim($request->answer)==trim($user->favorite_color)){
                session()->put('password_reset_user',$user->userId);
                return redirect(route('newPassword'));
            }
        }else {
            if(trim($request->answer)==trim($user->child_birth_year)){
                session()->put('password_reset_user',$user->userId);
                return redirect(route('newPassword'));
            }
        }

        return back()->with('error','Câu trả lời bảo mật không đúng');
    }
    public function newPassword(){
        if(!session()->has('password_reset_user')){
            return redirect('/forgotPassword')
            ->with('error','Phiên reset đã hết hạn');
        }

        return redirect('/portal/resetPassword');
    }

    public function resetPassword(Request $request){
        $request->validate([
            'newPassword'=>'required',
            'verifyPassword'=>'required'
        ]);

        if (!$request->newPassword==$request->verifyPassword){
            return redirect('resetPassword')
            ->with('error','Nhập lại mật khẩu không khớp');
        }

        $userId = session()->get('password_reset_user');

        $user = User::find($userId);

        if(!$user){
            return redirect('/forgot-password')
            ->with('error','Không tìm thấy người dùng');
        }

        $user->password = Hash::make($request->newPassword);

        $user->save();

        session()->forget('password_reset_user');

        return redirect('/')
        ->with('success','Đổi mật khẩu thành công');
    }

}
