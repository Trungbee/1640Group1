<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController
{
    public function home() {
        return view("admin.home");
    }
    public function newUser(){
        return view("admin.newUser");
    }
    public function userManagement() {
        return view("admin.userManagement");
    }
    public function dashboard(){
        return view("admin.dashboard");
    }
    public function socialmedia()
    {
        return view('admin.socialmedia');
    }
    public function staffmanagement()
    {
        return view('admin.staffmanagement');
    }
}
