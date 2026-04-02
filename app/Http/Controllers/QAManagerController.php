<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;

class QAManagerController extends Controller
{
    public function home() {
        return view("qa_manager.home");
    }

    public function staffManagement(){
        $users = User::all();
        return view("qa_manager.staffManagement", compact('users'));
    }

    public function viewUpdateUser($userId){
        $user = User::findOrFail($userId);
        return view('qa_manager.updateUser', compact('user'));
    }

    public function updateUser(Request $request, $userId){
        $request->validate([
            'password' => ['max:20'],
            'role'     => ['required','in:Staff,QACoordinator,QAManager']
        ]);
        $user = User::findOrFail($userId);
        $user->role = $request->role;
        if ($request->password!= null){
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    public function deleteUser($userId){
        $user = User::findOrFail($userId);
        $ideas = Idea::where('userId', $userId)->get();
        foreach ($ideas as $idea) {
            // Delete physical files saved in the storage folder to free up hard drive space.
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($idea->filePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($idea->filePath);
            }

            // Remove all votes (reactions) related to this post.
            \App\Models\Reaction::where('ideaId', $idea->ideaId)->delete();

            // Delete Post
            $idea->delete();
        }

        $user->delete();
        return back()->with('success', 'Account deleted successfully!');
    }
}
