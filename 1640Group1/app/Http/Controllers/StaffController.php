<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Idea;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function home() {
        $userId = Auth::id();

        // 1. Display total ideas from staff
        $totalIdeas = Idea::where('userId', $userId)->count();

        // 2. Display total Vote from staff
        $totalMyVotes = Reaction::where('userId', $userId)->count();

        // 3. GLOBAL ENGAGEMENT: % Interaction
        $totalSystemIdeas = Idea::count();

        $engagementPercentage = 0;
        if ($totalSystemIdeas > 0) {
            $engagementPercentage = min(100, round(($totalMyVotes / $totalSystemIdeas) * 100));
        }

        return view('staff.home', compact('totalIdeas', 'totalMyVotes', 'engagementPercentage'));
    }

    public function mySubmissions() {
        $categories = Category::all();
        $myIdeas = Idea::where('userId', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('staff.mySubmissions', compact('categories', 'myIdeas'));
    }

    public function authSetup(){
        $user = User::find(session('loginId'));
        if($user && $user->favorite_animal != null){
            return redirect('/staff/home');
        }
        return view('staff.authSetup');
    }

    public function authQuestionSetup(Request $request){
        $request->validate([
            'favorite_animal' => ['required'],
            'favorite_color' => ['required'],
            'child_birth_year' => ['required'],
            'term' => ['required']
        ]);

        $user = User::findOrFail(session('loginId'));
        $user->favorite_animal = $request->favorite_animal;
        $user->favorite_color = $request->favorite_color;
        $user->child_birth_year = $request->child_birth_year;
        $user->save();

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
        $idea->is_anonymous = $request->has('is_anonymous');

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('ideas', 'public');
            $idea->filePath = $path;
        }

        $idea->save();

        return redirect()->route('staff.mySubmissions')->with('success', 'Idea submitted successfully!');
    }

    public function socialMedia(Request $request)
    {
        $sort = $request->query('sort', 'latest');

        $query = Idea::with(['user', 'comments.user'])
            ->withCount([
                'reactions as upvotes' => function ($q) { $q->where('is_upvote', true); },
                'reactions as downvotes' => function ($q) { $q->where('is_upvote', false); }
            ]);

        if ($sort === 'popular') {
            // Sắp xếp theo hiệu số Like - Dislike
            $query->orderByRaw('(
                (SELECT COUNT(*) FROM reactions WHERE reactions."ideaId" = ideas."ideaId" AND is_upvote = true) -
                (SELECT COUNT(*) FROM reactions WHERE reactions."ideaId" = ideas."ideaId" AND is_upvote = false)
            ) DESC');
        } elseif ($sort === 'viewed') {
            $query->orderBy('views', 'desc');
        } elseif ($sort === 'comments') {
            $query->addSelect(['last_comment_at' => Comment::select('created_at')
                ->whereColumn('ideaId', 'ideas.ideaId')
                ->latest()
                ->take(1)
            ]);

            // Sort by priority - new comment -> post date
            $query->orderByRaw('GREATEST(
                COALESCE((SELECT MAX(created_at) FROM comments WHERE comments."ideaId" = ideas."ideaId"), ideas.created_at),
                ideas.created_at
            ) DESC');
        } else {
            // Latest Ideas
            $query->orderBy('created_at', 'desc');
        }

        $ideas = $query->paginate(5)->withQueryString();
        $myReactions = Reaction::where('userId', Auth::id())->pluck('is_upvote', 'ideaId')->toArray();

        return view('staff.socialMedia', compact('ideas', 'myReactions', 'sort'));
    }

    public function storeComment(Request $request, $ideaId)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        Comment::create([
            'ideaId' => $ideaId,
            'userId' => Auth::id(),
            'content' => (string) $request->input('content'),
            'is_anonymous' => $request->has('is_anonymous')
        ]);

        return redirect()->back()->with('success', 'Your comment has been posted!');
    }

    public function downloadIdea($id)
    {
        $idea = Idea::findOrFail($id);
        $filePath = storage_path('app/public/' . $idea->filePath);

        $zipFileName = 'Idea_Doc_' . $idea->ideaId . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            if (file_exists($filePath) && !is_dir($filePath)) {
                $zip->addFile($filePath, basename($filePath));
            } else {
                $zip->addFromString('readme.txt', "Placeholder for seeded data.");
            }
            $zip->close();
        } else {
            return back()->with('error', 'Failed to create ZIP file.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function react(Request $request, $id)
    {
        $idea = Idea::findOrFail($id);

        // Check deadline (End of the week of the idea's creation date)
        $deadline = Carbon::parse($idea->created_at)->endOfWeek();

        if (now()->greaterThan($deadline)) {
            return response()->json(['message' => 'The voting period ended last Sunday!'], 403);
        }

        $isUpvote = $request->action === 'upvote';
        $userId = Auth::id();
        $reaction = Reaction::where('ideaId', $id)->where('userId', $userId)->first();

        if ($reaction) {
            if ($reaction->is_upvote == $isUpvote) {
                $reaction->delete();
            } else {
                $reaction->update(['is_upvote' => $isUpvote]);
            }
        } else {
            Reaction::create([
                'ideaId' => $id,
                'userId' => $userId,
                'is_upvote' => $isUpvote
            ]);
        }

        return response()->json([
            'upvotes' => Reaction::where('ideaId', $id)->where('is_upvote', true)->count(),
            'downvotes' => Reaction::where('ideaId', $id)->where('is_upvote', false)->count()
        ]);
    }

    public function editIdea($id)
    {
        $idea = Idea::findOrFail($id);
        if ($idea->userId !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $deadline = Carbon::parse($idea->created_at)->endOfWeek();
        if (now()->greaterThan($deadline)) {
            return redirect()->route('staff.mySubmissions')->with('error', 'This post is locked for editing!');
        }

        $categories = Category::all();
        return view('staff.editIdea', compact('idea', 'categories'));
    }

    public function updateIdea(Request $request, $id)
    {
        $idea = Idea::findOrFail($id);

        if ($idea->userId !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required',
            'document' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->categoryId = $request->category_id;

        if ($request->hasFile('document')) {
            if ($idea->filePath && Storage::disk('public')->exists($idea->filePath)) {
                Storage::disk('public')->delete($idea->filePath);
            }
            $path = $request->file('document')->store('ideas', 'public');
            $idea->filePath = $path;
        }

        $idea->save();
        return redirect()->route('staff.mySubmissions')->with('success', 'Updated successfully!');
    }

    public function incrementView($ideaId)
    {
        $idea = Idea::find($ideaId);
        if ($idea) {
            $idea->increment('views');
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
