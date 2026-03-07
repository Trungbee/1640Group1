<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Thêm dòng này để gọi AuthController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Đây là route mặc định của Laravel (Trang Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Đây là route để hiển thị trang Sign Up
Route::get('/sign-up', [AuthController::class, 'showSignUpForm']);

// Route nhận dữ liệu từ form khi người dùng bấm nút REGISTER
Route::post('/register', [AuthController::class, 'register']);
