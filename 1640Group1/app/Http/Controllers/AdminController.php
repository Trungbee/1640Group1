<?php

namespace App\Http\Controllers;
use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController
{
    public function home() {
        return view("admin.home");
    }
    public function newUser(){
        return view("admin.newUser");
    }
    public function createNewUser(Request $request){
        $request->validate([
            'name' => ['required'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','min:5','max:20'],
            'role' => ['required','in:Staff,admin']
        ]);
        User::create([
            'name'     => $request->name,
            'email'        => $request->email,
            'password' => Hash::make($request->password),
            'role'         => $request->role,
            'acceptTerms' => false
        ]);
        return view('admin.home');
    }
    public function userManagement() {
        return view("admin.userManagement");
    }
    public function dashboard(){
        // 1. Đếm số lượng Idea theo từng Category
        $ideasByCategory = \App\Models\Idea::join('categories', 'ideas.categoryId', '=', 'categories.categoryId')
            ->select('categories.name', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('categories.categoryId', 'categories.name')
            ->get();

        // 2. Đếm số lượng Idea theo từng Staff
        $ideasByStaff = \App\Models\Idea::join('users', 'ideas.userId', '=', 'users.userId')
            ->select('users.name', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('users.userId', 'users.name')
            ->get();

        // 3. Truyền 2 biến dữ liệu này sang file giao diện
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

    public function ideaList()
    {
    // Lấy danh sách bài đăng, kèm theo thông tin User và Category
    $ideas = Idea::with(['user', 'category'])->orderBy('created_at', 'desc')->get();
    return view('admin.ideaList', compact('ideas'));
    }
}
