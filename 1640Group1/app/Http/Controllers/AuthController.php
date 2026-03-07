<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showSignUpForm()
    {
        return view('signup');
    }

    public function register(Request $request)
    {
    // 1. Khai báo các quy tắc kiểm tra dữ liệu
        $validatedData = $request->validate([
            // Thêm min:3 để bắt buộc tên người dùng có ít nhất 3 ký tự
            'username' => 'required|string|min:3|max:255',

            // Đổi nullable thành required để bắt buộc phải nhập số điện thoại
            'phone'    => 'required|string|max:15',

            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:staff,qa_coordinator,qa_management'
        ]);

        // 2. Nếu dữ liệu VƯỢT QUA bài kiểm tra, code mới chạy xuống dòng này.
        // Tạm thời in ra màn hình để báo thành công.
        dd("Dữ liệu chuẩn xác! Đã sẵn sàng lưu vào Database: ", $validatedData);
    }
}
