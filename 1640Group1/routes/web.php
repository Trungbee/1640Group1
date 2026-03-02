<?php

use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortalController;

Route::get('/',[PortalController::class,'login'])->name('login');
Route::get('/forgotPassword',[PortalController::class,'forgotPassword'])->name('forgotPassword');
Route::get('/newPassword',[PortalController::class,'newPassword'])->name('newPassword');

Route::get('/admin/home', [AdminController::class,'home'])->name('admin-home');
Route::get('/admin/newUser', [AdminController::class,'newUser'])->name('admin-newUser');
Route::get('/admin/userManangement', [AdminController::class,'userManagement'])->name('admin-userManagement');
