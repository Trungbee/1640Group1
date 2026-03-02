<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function login(){
        return view("portal.login");
    }

    public function forgotPassword(){
        return view("portal.forgotPassword");
    }
    public function newPassword(){
        return view("portal.newPassword");
    }
}
