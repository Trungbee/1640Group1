<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QACoordinatorController;
use App\Http\Controllers\QAManagerController;

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
        Route::get('/staffManagement', [AdminController::class, 'staffmanagement'])->name('admin.staffManagement');
        Route::get('/updateUser/{userId}', [AdminController::class, 'viewUpdateUser'])->name('admin.updateUser');
        Route::post('/updateUser/{userId}', [AdminController::class, 'updateUser'])->name('updateUser');
        Route::get('/deleteUser/{userId}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

        // Ideas & Media
        Route::get('/ideas', [AdminController::class, 'ideaList'])->name('admin.ideas');

        // Xóa bài đăng
        Route::delete('/ideas/{id}', [AdminController::class, 'deleteIdea'])->name('admin.deleteIdea');

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

        // Route cho trang My Submissions
        Route::get('/my-submissions', [StaffController::class, 'mySubmissions'])->name('staff.mySubmissions');
        Route::post('/submit-idea', [StaffController::class, 'storeIdea'])->name('idea.store');

        // --- ĐÃ THÊM 2 ROUTE NÀY CHO TÍNH NĂNG CHỈNH SỬA BÀI VIẾT (CRUD) ---
        // Route hiển thị trang chỉnh sửa một bài viết cụ thể
        Route::get('/my-submissions/edit/{id}', [StaffController::class, 'editIdea'])->name('staff.editIdea');
        // Route xử lý cập nhật dữ liệu sau khi sửa
        Route::put('/my-submissions/update/{id}', [StaffController::class, 'updateIdea'])->name('staff.updateIdea');
        // ------------------------------------------------------------------

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

    // --- COORDINATOR ROUTES ---
    Route::prefix('qa_coordinator')->group(function () {
        Route::get('/home', [QACoordinatorController::class, 'home'])->name('qa_coordinator.home');

        // Quản lý category
        Route::get('/newCategory', [AdminController::class, 'newCategory'])->name('qa_coordinator.newCategory');
        Route::post('/newCategory', [AdminController::class, 'createNewCategory'])->name('createNewCategory');
        Route::get('/categoryManagement', [QACoordinatorController::class, 'categoryManagement'])->name('qa_coordinator.categoryManagement');
        Route::get('/updateCategory/{categoryId}', [QACoordinatorController::class, 'viewUpdateCategory'])->name('qa_coordinator.updateCategory');
        Route::post('/updateCategory/{categoryId}', [QACoordinatorController::class, 'updateCategory'])->name('updateCategory');
        Route::get('/deleteCategory/{categoryId}', [QACoordinatorController::class, 'deleteCategory'])->name('qa_coordinator.deleteCategory');

        // Quản lý idea
        Route::get('/ideaManagement', [QACoordinatorController::class, 'ideaManagement'])->name('qa_coordinator.ideaManagement');
        Route::get('/deleteIdea/{ideaId}', [QACoordinatorController::class, 'deleteIdea'])->name('qa_coordinator.deleteIdea');

        // Thiết lập câu hỏi bảo mật
        Route::get('/authSetup', [StaffController::class, 'authSetup'])->name('staff.authSetup');
        Route::post('/authSetup', [StaffController::class, 'authQuestionSetup'])->name('createAuthAnswer');
    });

    Route::prefix('qa_manager')->group(function () {
        Route::get('/home', [QAManagerController::class, 'home'])->name('qa_manager.home');

        // Quản lý người dùng
        Route::get('/newUser', [AdminController::class, 'newUser'])->name('admin.newUser');
        Route::post('/newUser', [AdminController::class, 'createNewUser'])->name('createNewUser');
        Route::get('/userManagement', [AdminController::class, 'userManagement'])->name('admin.userManagement');
        Route::get('/staffManagement', [AdminController::class, 'staffmanagement'])->name('admin.staffManagement');
        Route::get('/updateUser/{userId}', [AdminController::class, 'viewUpdateUser'])->name('admin.updateUser');
        Route::post('/updateUser/{userId}', [AdminController::class, 'updateUser'])->name('updateUser');
        Route::get('/deleteUser/{userId}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

        // Thiết lập câu hỏi bảo mật
        Route::get('/authSetup', [StaffController::class, 'authSetup'])->name('staff.authSetup');
        Route::post('/authSetup', [StaffController::class, 'authQuestionSetup'])->name('createAuthAnswer');
    });


    // --- LOGOUT ---
    Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

});
