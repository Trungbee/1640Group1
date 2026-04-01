<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use ZipArchive;

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

    public function userManagement() {
        return view("admin.userManagement");
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

        // Compile the numbers for the Summary tag.
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
        public function downloadIdea($id)
    {
        // Find idea or throw 404 error
        $idea = Idea::findOrFail($id);

        // Define the path to the original file uploaded by the user (if it exists)
        $filePath = storage_path('app/public/' . $idea->filePath);

        // Create a ZIP file name based on the idea's ID and title for better identification
        $zipFileName = 'Admin_Idea_Doc_' . $idea->ideaId . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            // Check if the original file exists and is not a directory before adding it to the ZIP
            if (file_exists($filePath) && !is_dir($filePath)) {
                $zip->addFile($filePath, basename($filePath));
            } else {
                // If it'sSeeder data without the actual file, create a notification file inside the ZIP
                $zip->addFromString('system_notice.txt', "Tai lieu goc khong ton tai do day la du lieu mau (Seeder).");
            }

            $zip->close();
        } else {
            return back()->with('error', 'Could not create ZIP file');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}

