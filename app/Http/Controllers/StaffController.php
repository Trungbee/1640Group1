<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function home() {
        $userId = \Illuminate\Support\Facades\Auth::id();

        // Display total ideals from staff
        $totalIdeas = \App\Models\Idea::where('userId', $userId)->count();

        // 2. Display total Vote from staff
        $totalMyVotes = \App\Models\Reaction::where('userId', $userId)->count();

        // 3. GLOBAL ENGAGEMENT: % Interaction
        $totalSystemIdeas = \App\Models\Idea::count(); // Total number of articles across the entire system

        $engagementPercentage = 0;
        if ($totalSystemIdeas > 0) {
            // Calculate the percentage and use the min() function to ensure it is a maximum of 100%
            $engagementPercentage = min(100, round(($totalMyVotes / $totalSystemIdeas) * 100));
        }

        // Display to the staff home screen
        return view('staff.home', compact('totalIdeas', 'totalMyVotes', 'engagementPercentage'));
    }

    public function mySubmissions() {
        $categories = \App\Models\Category::all();
        $myIdeas = Idea::where('userId', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('staff.mySubmissions', compact('categories', 'myIdeas'));
    }

    public function authSetup(){
        $user = User::find(Auth::id());
        // Kiểm tra nếu đã có active_security_question thì không cần setup lại
        if (!empty($user->active_security_question)) {
            return redirect()->route('staff.home');
        }
        return view('staff.authSetup');
    }

    public function authQuestionSetup(Request $request){
        $request->validate([
            'security_question' => ['required', 'in:favorite_animal,favorite_color,child_birth_year'],
            'answer'            => ['required'],
            'term'              => ['required']
        ]);

        $user = User::find(Auth::id());

        if ($user) {
            $user->{$request->security_question}  = $request->answer;
            $user->active_security_question        = $request->security_question;
            $user->save();
            return redirect()->route('staff.home')->with('success', 'Security question set up successfully!');
        }

        return redirect()->route('loginPage');
    }

    public function storeIdea(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'document' => 'required|mimes:pdf,doc,docx|max:10240',
        ]);

        $idea = new Idea();
        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->categoryId = $request->category_id;
        $idea->userId = Auth::id();

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('ideas', 'public');
            $idea->filePath = $path;
        }

        $idea->save();

        return redirect()->route('staff.mySubmissions')->with('success', 'Idea submitted successfully!');
    }

    public function socialMedia()
    {
        $ideas = \App\Models\Idea::with('user')
            ->withCount([
                'reactions as upvotes' => function ($query) { $query->where('is_upvote', true); },
                'reactions as downvotes' => function ($query) { $query->where('is_upvote', false); }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $myReactions = \App\Models\Reaction::where('userId', Auth::id())->pluck('is_upvote', 'ideaId')->toArray();

        return view('staff.socialMedia', compact('ideas', 'myReactions'));
    }

    public function downloadIdea($id)
    {
        $idea = \App\Models\Idea::findOrFail($id);
        $path = storage_path('app/public/' . $idea->filePath);
        return response()->download($path);
    }

    public function react(Request $request, $id)
    {
        $idea = \App\Models\Idea::findOrFail($id);

        $deadline = Carbon::parse($idea->created_at)->endOfWeek();

        if (now()->greaterThan($deadline)) {
            return response()->json(['message' => 'The voting period for this post ended last Sunday!'], 403);
        }

        $isUpvote = $request->action === 'upvote';
        $userId = Auth::id();

        $reaction = \App\Models\Reaction::where('ideaId', $id)->where('userId', $userId)->first();

        if ($reaction) {
            if ($reaction->is_upvote == $isUpvote) {
                $reaction->delete();
            } else {
                $reaction->update(['is_upvote' => $isUpvote]);
            }
        } else {
            \App\Models\Reaction::create([
                'ideaId' => $id,
                'userId' => $userId,
                'is_upvote' => $isUpvote
            ]);
        }

        $upvotes = \App\Models\Reaction::where('ideaId', $id)->where('is_upvote', true)->count();
        $downvotes = \App\Models\Reaction::where('ideaId', $id)->where('is_upvote', false)->count();

        return response()->json(['upvotes' => $upvotes, 'downvotes' => $downvotes]);
    }

    // Display CRUD Ideals (Staff) & Check Deadline
    public function editIdea($id)
    {
        $idea = Idea::findOrFail($id);
        // Check Author, if not author, Can't be edit ideas.
        if ($idea->userId !== Auth::id()) {
            abort(403, 'You have no permission to edit other people ideas!');
        }

        // Check Time if close vote, can't edit anymore.
        $deadline = Carbon::parse($idea->created_at)->endOfWeek();
        if (now()->greaterThan($deadline)) {
            return redirect()->route('staff.mySubmissions')->with('error', 'This post is now closed for voting. You can no longer edit the content!');
        }

        $categories = \App\Models\Category::all();

        return view('staff.editIdea', compact('idea', 'categories'));
    }

    // Update Data after Edit/Update.
    public function updateIdea(Request $request, $id)
    {
        $idea = Idea::findOrFail($id);

        if ($idea->userId !== Auth::id()) {
            abort(403, 'You have no permission to edit other people ideas!');
        }

        $deadline = Carbon::parse($idea->created_at)->endOfWeek();
        if (now()->greaterThan($deadline)) {
            return redirect()->route('staff.mySubmissions')->with('error', 'Action rejected: Post has been locked!');
        }

        // Validate data
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required',
            'document' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->categoryId = $request->category_id;

        // Handle Upload File
        if ($request->hasFile('document')) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($idea->filePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($idea->filePath);
            }

            $path = $request->file('document')->store('ideas', 'public');
            $idea->filePath = $path;
        }

        $idea->save();

        return redirect()->route('staff.mySubmissions')->with('success', 'The idea has been updated successfully !');
    }
}
