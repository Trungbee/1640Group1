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
        // Check input data
        $request->validate([
            'username' => ['required', 'unique:users,username'],
            'fullName' => ['required'],
            'email'    => ['required','email','unique:users,email'],
            'password' => ['required','min:5','max:20'],
            'role'     => ['required','in:Staff,Admin,QACoordinator,QAManager']
        ]);

        // Save to Database
        User::create([
            'username'    => $request->username,
            'fullName'    => $request->fullName, // Thêm dòng này
            'email'       => $request->email,
            'passwordHash'=> Hash::make($request->password),
            'role'        => $request->role,
            'acceptTerms' => false
        ]);

        // Redirection with a success message.
        return redirect()->back()->with('success', 'New account created successfully!');
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
        $users = User::all();
        return view('admin.staffManagement', compact('users'));
    }

    public function deleteUser($userId){
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect()->back();
    }
    public function viewUpdateUser($userId){
        $user = User::findOrFail($userId);
        return view('admin.updateUser', compact('user'));
    }

    public function updateUser(Request $request, $userId){
        $request->validate([
            'password' => ['max:20'],
            'role'     => ['required','in:Staff,QACoordinator,QAManager']
        ]);
        $user = User::findOrFail($userId);
        $user->role = $request->role;
        if ($request->password!= null){
            $user->passwordHash = Hash::make($request->password);
        }
        if ($request->resetQuestion){
            $user->favorite_animal = null;
            $user->favorite_color = null;
            $user->child_birth_year = null;
        }

        $user->save();

        return redirect('/staffManagement');
    }

    // Count Vote
    public function ideaList()
    {
        // Get a list of posts, including User, Category, and COUNT the number of LIKES/DISLIKES.
        $ideas = Idea::with(['user', 'category'])
            ->withCount([
                'reactions as upvotes' => function ($query) { $query->where('is_upvote', true); },
                'reactions as downvotes' => function ($query) { $query->where('is_upvote', false); }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ideaList', compact('ideas'));
    }

    // Function to handle post deletion
    public function deleteIdea($id)
    {
        $idea = Idea::findOrFail($id);

        // Delete physical files saved in the storage folder to free up hard drive space.
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($idea->filePath)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($idea->filePath);
        }

        // Remove all votes (reactions) related to this post.
        \App\Models\Reaction::where('ideaId', $id)->delete();

        // Delete Post
        $idea->delete();

        return redirect()->back()->with('success', 'Idea and related files have been deleted successfully.');
    }
}
