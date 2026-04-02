<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            'fullName'    => $request->fullName,
            'email'       => $request->email,
            'passwordHash'=> Hash::make($request->password),
            'role'        => $request->role,
            'acceptTerms' => false
        ]);

        // Redirection with a success message.
        return redirect()->back()->with('success', 'New account created successfully!');
    }

    // DASHBOARD
    public function dashboard(){
        // Bar Chart (Ideas by Category)
        $ideasByCategory = Idea::join('categories', 'ideas.categoryId', '=', 'categories.categoryId')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.categoryId', 'categories.name')
            ->get();

        // Horizontal Bar Chart (Top 5 Employees)
        $topStaffs = Idea::join('users', 'ideas.userId', '=', 'users.userId')
            ->select('users.fullName', 'users.username', DB::raw('count(*) as total'))
            ->groupBy('users.userId', 'users.fullName', 'users.username')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Pie Chart (Role ratio)
        $usersByRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get();

        // Doughnut Chart (Total votes across the entire system)
        $totalUpvotes = \App\Models\Reaction::where('is_upvote', true)->count();
        $totalDownvotes = \App\Models\Reaction::where('is_upvote', false)->count();

        // Line Chart (Daily posting trends)
        $ideasTrend = Idea::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit(14) // Get the last 14 days
            ->get();

        // Stacked Bar Chart (Emotions - Vote by Category)
        $reactionsByCategory = \App\Models\Category::leftJoin('ideas', 'categories.categoryId', '=', 'ideas.categoryId')
            ->leftJoin('reactions', 'ideas.ideaId', '=', 'reactions.ideaId')
            ->select(
                'categories.name',
                DB::raw('COUNT(CASE WHEN reactions.is_upvote = true THEN 1 END) as upvotes'),
                DB::raw('COUNT(CASE WHEN reactions.is_upvote = false THEN 1 END) as downvotes')
            )
            ->groupBy('categories.categoryId', 'categories.name')
            ->get();

        // Tổng hợp con số cho thẻ Summary
        $totalUsers = User::count();
        $totalIdeas = Idea::count();

        return view("admin.dashboard", compact(
            'ideasByCategory',
            'topStaffs',
            'usersByRole',
            'totalUpvotes',
            'totalDownvotes',
            'ideasTrend',
            'reactionsByCategory',
            'totalUsers',
            'totalIdeas'
        ));
    }

    public function socialmedia()
    {
        return view('admin.socialmedia');
    }

    public function staffmanagement()
    {
        $users = User::all();
        return view('admin.staffmanagement', compact('users'));
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

        return back()->with('success', 'Updated');
    }

    public function categoryManagement(){
        $categories = \App\Models\Category::all();
        return view('admin.categoryManagement', compact('categories'));
    }

    public function newCategory(){
        return view('admin.newCategory');
    }

    public function createNewCategory(Request $request){
        // Check input data
        $request->validate([
            'name' => ['required', 'unique:categories,name']
        ]);
        // Save to Database
        Category::create([
            'name'    => $request->name
        ]);

        return redirect()->back()->with('success', 'New category added successfully!');
    }

    public function deleteCategory($categoryId){
        $category = Category::findOrFail($categoryId);

        if (Idea::where('categoryId', $categoryId)->exists()){
            return back()->with('error', 'Cannot delete category that has ideas.');
        }
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
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
