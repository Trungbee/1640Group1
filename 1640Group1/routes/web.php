<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;

// CÁC ROUTE CÔNG KHAI (Dành cho khách chưa đăng nhập)
Route::middleware('guest')->group(function () {
    // Trang chủ & Đăng nhập
    Route::get('/', [PortalController::class, 'showLogin'])->name('loginPage');
    Route::post('/', [PortalController::class, 'login'])->name('login');

    // Quên mật khẩu & Reset
    Route::get('/forgotPassword', [PortalController::class, 'showForgotPassword'])->name('forgotPassword');
    Route::post('/forgotPassword', [PortalController::class, 'verifyQuestion'])->name('verifyQuestion');
    Route::get('/newPassword', [PortalController::class, 'newPassword'])->name('newPassword');
    Route::post('/resetPassword', [PortalController::class, 'resetPassword'])->name('passwordReset');
});


// CÁC ROUTE ĐƯỢC BẢO VỆ (Bắt buộc phải đăng nhập mới được vào)
Route::middleware('auth')->group(function () {

    // --- ADMIN ROUTES ---
    Route::prefix('admin')->group(function () {
        Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Quản lý người dùng
        Route::get('/newUser', [AdminController::class, 'newUser'])->name('admin.newUser');
        Route::post('/newUser', [AdminController::class, 'createNewUser'])->name('createNewUser');
        Route::get('/userManagement', [AdminController::class, 'userManagement'])->name('admin.userManagement');
        Route::get('/staffManagement', [AdminController::class, 'staffmanagement'])->name('admin.staffmanagement');

        // Ideas & Media
        Route::get('/ideas', [AdminController::class, 'ideaList'])->name('admin.ideas');

        // --- ĐÃ THÊM ROUTE NÀY CHO CHỨC NĂNG XÓA BÀI ĐĂNG ---
        Route::delete('/ideas/{id}', [AdminController::class, 'deleteIdea'])->name('admin.deleteIdea');
        // ----------------------------------------------------

        Route::get('/socialmedia', [AdminController::class, 'socialmedia'])->name('admin.socialmedia');

        // Download Idea
        Route::get('/download/{id}', function ($id) {
            $idea = \App\Models\Idea::findOrFail($id);
            $path = storage_path('app/public/' . $idea->filePath);
            return response()->download($path);
        })->name('admin.download');
    });

    // --- STAFF ROUTES ---
    Route::prefix('staff')->group(function () {
        Route::get('/home', [StaffController::class, 'home'])->name('staff.home');

        // 1. Route cho trang My Submissions
        Route::get('/my-submissions', [StaffController::class, 'mySubmissions'])->name('staff.mySubmissions');

        Route::post('/submit-idea', [StaffController::class, 'storeIdea'])->name('idea.store');

        // Trang Social Media của Staff
        Route::get('/social-media', [StaffController::class, 'socialMedia'])->name('staff.socialMedia');

        // Tải file
        Route::get('/download-idea/{id}', [StaffController::class, 'downloadIdea'])->name('staff.downloadIdea');

        // Bấm Like / Dislike
        Route::post('/react-idea/{id}', [StaffController::class, 'react'])->name('staff.reactIdea');

        // Thiết lập câu hỏi bảo mật
        Route::get('/authSetup', [StaffController::class, 'authSetup'])->name('staff.authSetup');
        Route::post('/authSetup', [StaffController::class, 'authQuestionSetup'])->name('createAuthAnswer');
    });

    // --- LOGOUT ---
    Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

});
