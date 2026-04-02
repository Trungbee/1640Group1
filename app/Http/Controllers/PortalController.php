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

                // Nếu là Staff, kiểm tra xem đã setup câu hỏi bảo mật chưa
                if (empty($user->active_security_question)) {
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
            return back()->with('error','Email not found.')->withInput();
        }

        // Chỉ chấp nhận đúng câu hỏi đang active
        if ($request->security_question !== $user->active_security_question) {
            return back()->withErrors(['security_question' => 'Please select the correct security question.'])->withInput();
        }

        // So sánh câu trả lời (không phân biệt hoa thường, bỏ khoảng trắng thừa)
        $userAnswer = trim($user->{$request->security_question});
        if (strtolower(trim($request->answer)) === strtolower($userAnswer)) {
            session()->put('password_reset_user', $user->userId);
            return redirect(route('newPassword'));
        }

        return back()->withErrors(['answer' => 'The security answer is incorrect.'])->withInput();
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

    // --- CHANGE PASSWORD (khi đã đăng nhập) ---
    public function showChangePassword()
    {
        $user = User::find(Auth::id());

        // Nếu chưa setup câu hỏi bảo mật → bắt setup trước
        if (empty($user->active_security_question)) {
            session()->put('security_questions_user', $user->userId);
            return redirect()->route('securityQuestionsEdit')
                ->with('info', 'Please set up your security question before changing your password.');
        }

        return view('portal.changePassword');
    }

    public function verifyChangePassword(Request $request)
    {
        $request->validate([
            'current_password'  => ['required'],
            'security_question' => ['required', 'in:favorite_animal,favorite_color,child_birth_year'],
            'answer'            => ['required'],
        ]);

        // Luôn lấy fresh từ DB, không dùng cached Auth::user()
        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->passwordHash)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        // Chỉ chấp nhận đúng câu hỏi đang active
        if ($request->security_question !== $user->active_security_question) {
            return back()->withErrors(['security_question' => 'Please select the correct security question.'])->withInput();
        }

        $userAnswer = trim($user->{$request->security_question});
        if (strtolower(trim($request->answer)) !== strtolower($userAnswer)) {
            return back()->withErrors(['answer' => 'The security answer is incorrect.'])->withInput();
        }

        session()->put('change_password_user', $user->userId);
        return redirect()->route('changePasswordNew');
    }

    public function showChangePasswordNew()
    {
        if (!session()->has('change_password_user')) {
            return redirect()->route('changePassword')->with('error', 'Session expired. Please verify again.');
        }
        return view('portal.changePasswordNew');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'newPassword'    => 'required|min:5',
            'verifyPassword' => 'required|same:newPassword',
        ]);

        $userId = session()->get('change_password_user');
        $user   = User::find($userId);

        if (!$user) {
            return redirect()->route('changePassword')->with('error', 'User not found.');
        }

        $user->passwordHash = Hash::make($request->newPassword);
        $user->save();

        session()->forget('change_password_user');

        $role = strtolower($user->role);
        if ($role === 'admin') {
            return redirect()->route('admin.home')->with('success', 'Password changed successfully!');
        }
        return redirect()->route('staff.home')->with('success', 'Password changed successfully!');
    }

    // --- SECURITY QUESTIONS MANAGEMENT (khi đã đăng nhập) ---
    public function showSecurityQuestions()
    {
        $user = User::find(Auth::id());

        // Nếu chưa có active_security_question → bỏ qua bước xác minh, vào thẳng form setup
        if (empty($user->active_security_question)) {
            session()->put('security_questions_user', $user->userId);
            return redirect()->route('securityQuestionsEdit')
                ->with('info', 'You have not set up a security question yet. Please create one now.');
        }

        return view('portal.securityQuestions');
    }

    public function verifySecurityQuestion(Request $request)
    {
        $request->validate([
            'security_question' => ['required', 'in:favorite_animal,favorite_color,child_birth_year'],
            'answer'            => ['required'],
        ]);

        // Luôn lấy fresh từ DB, không dùng cached Auth::user()
        $user = User::find(Auth::id());

        // Chỉ chấp nhận đúng câu hỏi đang active
        if ($request->security_question !== $user->active_security_question) {
            return back()->withErrors(['security_question' => 'Please select the correct security question.'])->withInput();
        }

        $userAnswer = trim($user->{$request->security_question});
        if (strtolower(trim($request->answer)) !== strtolower($userAnswer)) {
            return back()->withErrors(['answer' => 'The security answer is incorrect.'])->withInput();
        }

        session()->put('security_questions_user', $user->userId);
        return redirect()->route('securityQuestionsEdit');
    }

    public function showSecurityQuestionsEdit()
    {
        if (!session()->has('security_questions_user')) {
            return redirect()->route('securityQuestions')->with('error', 'Session expired. Please verify again.');
        }
        $user         = User::find(Auth::id());
        $isFirstSetup = empty($user->active_security_question);
        return view('portal.securityQuestionsEdit', compact('user', 'isFirstSetup'));
    }

    public function updateSecurityQuestions(Request $request)
    {
        $request->validate([
            'security_question' => ['required', 'in:favorite_animal,favorite_color,child_birth_year'],
            'new_answer'        => ['required'],
        ]);

        $userId = session()->get('security_questions_user');
        $user   = User::find($userId);

        if (!$user) {
            return redirect()->route('securityQuestions')->with('error', 'User not found.');
        }

        $user->{$request->security_question} = $request->new_answer;
        $user->active_security_question       = $request->security_question;
        $user->save();

        session()->forget('security_questions_user');

        $role = strtolower($user->role);
        if ($role === 'admin') {
            return redirect()->route('admin.home')->with('success', 'Security question updated successfully!');
        }
        return redirect()->route('staff.home')->with('success', 'Security question updated successfully!');
    }
}
