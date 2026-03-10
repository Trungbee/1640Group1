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
}
