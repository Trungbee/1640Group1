<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;


Route::middleware('guest')->group(function () {
    // Đăng nhập
    Route::get('/', [PortalController::class, 'showLogin'])->name('loginPage');
    Route::post('/', [PortalController::class, 'login'])->name('login');

    // Quên mật khẩu
    Route::get('/forgotPassword', [PortalController::class, 'showForgotPassword'])->name('forgotPassword');
    Route::post('/forgotPassword', [PortalController::class, 'verifyQuestion'])->name('verifyQuestion');

    Route::get('/newPassword', [PortalController::class, 'newPassword'])->name('newPassword');
    Route::post('/resetPassword', [PortalController::class, 'resetPassword'])->name('passwordReset');

    // Sign Up (Nếu bạn muốn cho phép người ngoài đăng ký)
    Route::get('/sign-up', [AuthController::class, 'showSignUpForm']);
    Route::post('/register', [AuthController::class, 'register']);
});




    // --- ADMIN ROUTES ---
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/admin/newUser', [AdminController::class, 'newUser'])->name('admin.newUser');
    Route::post('/admin/newUser', [AdminController::class, 'createNewUser'])->name('createNewUser');

    Route::get('/admin/userManangement', [AdminController::class, 'userManagement'])->name('admin.userManagement');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/socialmedia', [AdminController::class, 'socialmedia'])->name('admin.socialmedia');
    Route::get('/admin/staffmanagement', [AdminController::class, 'staffmanagement'])->name('admin.staffmanagement');

    // Quản lý Ideas & Download
    Route::get('/admin/ideas', [AdminController::class, 'ideaList'])->name('admin.ideas');
    Route::get('/admin/download/{id}', function ($id) {
        $idea = \App\Models\Idea::findOrFail($id);
        $path = storage_path('app/public/' . $idea->filePath);
        return response()->download($path);
    })->name('admin.download');


    // --- STAFF ROUTES ---
    Route::get('/staff/home', [StaffController::class, 'home'])->name('staff.home');
    Route::post('/submit-idea', [StaffController::class, 'storeIdea'])->name('idea.store');

    // Thiết lập câu hỏi bảo mật
    Route::get('/staff/authSetup', [StaffController::class, 'authSetup'])->name('staff.authSetup');
    Route::post('/staff/authSetup', [StaffController::class, 'authQuestionSetup'])->name('staff.createAuthAnswer');


    // --- LOGOUT ---
    Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

