<?php

use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\StaffController;

Route::get('/',[PortalController::class,'showLogin'])->name('loginPage');
Route::post('/', [PortalController::class, 'login'])->name('login');

Route::get('/forgotPassword',[PortalController::class,'showForgotPassword'])->name('forgotPassword');
Route::post('/forgotPassword',[PortalController::class, 'verifyQuestion'])->name('verifyQuestion');

Route::get('/newPassword',[PortalController::class,'newPassword'])->name('newPassword');
Route::post('/resetPassword', [PortalController::class, 'resetPassword'])->name('passwordReset');

Route::get('/admin/home', [AdminController::class,'home'])->name('admin.home');
Route::get('/admin/newUser', [AdminController::class,'newUser'])->name('admin.newUser');
Route::post('/admin/newUser', [AdminController::class, 'createNewUser'])->name('createNewUser');
Route::get('/admin/userManangement', [AdminController::class,'userManagement'])->name('admin.userManagement');
Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
Route::get('/admin/socialmedia', [AdminController::class,'socialmedia'])->name('admin.socialmedia');
Route::get('/admin/staffmanagement', [AdminController::class,'staffmanagement'])->name('admin.staffmanagement');

Route::get('/staff/home',[StaffController::class,'home'])->name('staff.home');
Route::get('/staff/authSetup',[StaffController::class,'authSetup'])->name('staff.authSetup');
Route::post('/staff/authSetup',[StaffController::class,'authQuestionSetup'])->name('staff.createAuthAnswer');

Route::post('/logout',[PortalController::class,'logout'])->name('logout');

// Route::middleware('guest')->group(function (){
//     Route::View('/', 'portal.login')->name('login.show');


//     Route::View('/forgotPassword', 'portal.forgotPassword')->name('forgotPassword');
//     Route::post('/forgotPassword',[PortalController::class, 'verifyQuestion'])->name('verifyQuestion');
//     Route::get('/newPassword',[PortalController::class,'newPassword'])->name('newPassword');

//     Route::get('/resetPassword/{token}', [PortalController::class, 'showResetPassword'])->name('password.reset');
//     Route::post('/resetPassword', [PortalController::class, 'resetPassword'])->name('password.update');

// });
