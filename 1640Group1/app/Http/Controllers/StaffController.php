<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    public function home() {
        return view('staff.home');
    }
    public function authSetup(){
        return view('staff.authSetup');
    }
    public function authQuestionSetup(Request $request){
        $request->validate([
            'favorite_animal' => ['required'],
            'favorite_color' => ['required'],
            'child_birth_year' => ['required']
        ]);
        $user = User::find(session('loginId'));
        $user->update([
            'favorite_animal' => $request->favorite_animal,
            'favorite_color' => $request->favorite_color,
            'child_birth_year' => $request->child_birth_year
        ]);
        return view('staff.home');
    }
}
