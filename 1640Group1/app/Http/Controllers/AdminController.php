<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function home() {
        return view("admin.home");
    }

    public function newUser(){
        return view("admin.newUser");
    }

    public function createNewUser(Request $request){
        // 1. Kiểm tra đầu vào (Đã thêm fullName và set username là duy nhất)
        $request->validate([
            'username' => ['required', 'unique:users,username'],
            'fullName' => ['required'], // Bắt buộc phải nhập Họ và Tên
            'email'    => ['required','email','unique:users,email'],
            'password' => ['required','min:5','max:20'],
            'role'     => ['required','in:Staff,Admin,QACoordinator,QAManager']
        ]);

        // 2. Lưu vào Database (Bổ sung thêm fullName)
        User::create([
            'username'    => $request->username,
            'fullName'    => $request->fullName, // Thêm dòng này
            'email'       => $request->email,
            'passwordHash'=> Hash::make($request->password),
            'role'        => $request->role,
            'acceptTerms' => false
        ]);

        // 3. Chuyển hướng kèm thông báo thành công
        return redirect()->back()->with('success', 'Tạo tài khoản mới thành công!');
    }

    public function userManagement() {
        return view("admin.userManagement");
    }

    public function dashboard(){
        $ideasByCategory = Idea::join('categories', 'ideas.categoryId', '=', 'categories.categoryId')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.categoryId', 'categories.name')
            ->get();

        $ideasByStaff = Idea::join('users', 'ideas.userId', '=', 'users.userId')
            ->select('users.username', DB::raw('count(*) as total'))
            ->groupBy('users.userId', 'users.username')
            ->get();

        return view("admin.dashboard", compact('ideasByCategory', 'ideasByStaff'));
    }

    public function socialmedia()
    {
        return view('admin.socialmedia');
    }

    public function staffmanagement()
    {
        return view('admin.staffmanagement');
    }

    // --- 1. ĐÃ CẬP NHẬT: Tích hợp đếm lượt Vote ---
    public function ideaList()
    {
        // Lấy danh sách bài đăng, kèm theo User, Category và ĐẾM SỐ LƯỢNG LIKE/DISLIKE
        $ideas = Idea::with(['user', 'category'])
            ->withCount([
                'reactions as upvotes' => function ($query) { $query->where('is_upvote', true); },
                'reactions as downvotes' => function ($query) { $query->where('is_upvote', false); }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ideaList', compact('ideas'));
    }

    // --- 2. ĐÃ BỔ SUNG: Hàm xử lý xóa bài viết ---
    public function deleteIdea($id)
    {
        $idea = Idea::findOrFail($id);

        // Xóa file vật lý đã lưu trong thư mục storage để giải phóng ổ cứng
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($idea->filePath)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($idea->filePath);
        }

        // Xóa tất cả lượt Vote (Reactions) liên quan đến bài viết này
        \App\Models\Reaction::where('ideaId', $id)->delete();

        // Xóa bài viết
        $idea->delete();

        return redirect()->back()->with('success', 'Idea and related files have been deleted successfully.');
    }
}
