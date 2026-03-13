<?php

namespace App\Http\Controllers;

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
            'role' => ['required','in:staff,admin']
        ]);
        User::create([
            'name'     => $request->name,
            'email'        => $request->email,
            'password' => Hash::make($request->password),
            'role'         => $request->role,
            'acceptTerms' => true
        ]);
        return view('admin.home');
    }
    public function userManagement() {
        return view("admin.userManagement");
    }
    public function dashboard(){
        return view("admin.dashboard");
    }
}
