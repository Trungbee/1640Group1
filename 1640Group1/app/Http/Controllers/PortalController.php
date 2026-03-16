<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // Sửa lại chữ "app" viết hoa
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
            // Kiểm tra mật khẩu dựa trên cột passwordHash trong DB
            if (Hash::check($request->password, $user->passwordHash)) {

                // 1. Đăng nhập chính thức
                Auth::login($user, $request->has('remember'));

                // 2. Làm mới session để chống tấn công fixation và lưu ID cũ (nếu cần)
                $request->session()->regenerate();
                $request->session()->put('loginId', $user->userId);

                // 3. Xử lý chuyển hướng dựa trên vai trò
                $role = strtolower($user->role);

                if ($role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'));
                }

                // Nếu là Staff, kiểm tra xem đã setup câu hỏi bảo mật chưa
                if (empty($user->favorite_animal)) {
                    return redirect()->route('staff.authSetup');
                }

                return redirect()->intended(route('staff.home'));

            } else {
                return back()->withErrors(['password' => 'Mật khẩu không chính xác.'])->withInput();
            }
        } else {
            return back()->withErrors(['email' => 'Email này chưa được đăng ký.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginPage');
    }

    // --- CÁC HÀM QUÊN MẬT KHẨU GIỮ NGUYÊN ---
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

        // So sánh câu trả lời (xóa khoảng trắng thừa)
        $userAnswer = trim($user->{$request->security_question});
        if(trim($request->answer) === $userAnswer){
            session()->put('password_reset_user', $user->userId);
            return redirect(route('newPassword'));
        }

        return back()->with('error','Câu trả lời bảo mật không đúng');
    }

    public function newPassword(){
        if(!session()->has('password_reset_user')){
            return redirect()->route('forgotPassword')->with('error','Phiên reset đã hết hạn');
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
            return redirect()->route('forgotPassword')->with('error','Không tìm thấy người dùng');
        }

        $user->passwordHash = Hash::make($request->newPassword);
        $user->save();

        session()->forget('password_reset_user');

        return redirect()->route('loginPage')->with('success','Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
    }
}
