<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function home() {
        // Trang chủ giờ đây đã được giải phóng để dành cho các thống kê Dashboard (ví dụ: Tổng số idea, % tương tác...)
        return view('staff.home');
    }

    // --- HÀM MỚI: Xử lý trang My Submissions ---
    public function mySubmissions() {
        // Lấy tất cả môn học để đổ vào dropdown chọn Category
        $categories = \App\Models\Category::all();

        // Lấy danh sách các bài Idea mà Staff này đã nộp (để hiển thị bảng lịch sử)
        $myIdeas = Idea::where('userId', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('staff.mySubmissions', compact('categories', 'myIdeas'));
    }

    public function authSetup(){
        $user = User::find(session('loginId'));
        if(!$user->favorite_animal==null){
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

        $user = Auth::user();

        if($user) {
            $user->update([
                'favorite_animal' => $request->favorite_animal,
                'favorite_color' => $request->favorite_color,
                'child_birth_year' => $request->child_birth_year
            ]);
            return redirect()->route('staff.home')->with('success', 'Setup security questions completed!');
        }

        return redirect()->route('loginPage');
    }

    public function storeIdea(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'document' => 'required|mimes:pdf,doc,docx|max:10240', // Bắt buộc có file, tối đa 10MB
        ]);

        // 2. Tạo Idea mới
        $idea = new Idea();
        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->categoryId = $request->category_id;
        $idea->userId = Auth::id(); // Lấy ID người đang đăng nhập

        // 3. Xử lý Upload File
        if ($request->hasFile('document')) {
            // Lưu file vào thư mục storage/app/public/ideas
            $path = $request->file('document')->store('ideas', 'public');
            $idea->filePath = $path;
        }

        // 4. Lưu vào Database
        $idea->save();

        // 5. Quay về trang My Submissions kèm thông báo thành công
        return redirect()->route('staff.mySubmissions')->with('success', 'Idea submitted successfully!');
    }

    // --- 1. ĐÃ ĐỔI TÊN HÀM: Hiển thị trang Social Media ---
    public function socialMedia()
    {
        // Lấy tất cả Idea, kèm theo user và đếm số lượng like/dislike
        $ideas = \App\Models\Idea::with('user')
            ->withCount([
                'reactions as upvotes' => function ($query) { $query->where('is_upvote', true); },
                'reactions as downvotes' => function ($query) { $query->where('is_upvote', false); }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Lấy danh sách các vote của user hiện tại để tô màu xanh nút like/dislike
        $myReactions = \App\Models\Reaction::where('userId', Auth::id())->pluck('is_upvote', 'ideaId')->toArray();

        // Trả về file giao diện mới tên là socialMedia
        return view('staff.socialMedia', compact('ideas', 'myReactions'));
    }

    // --- 2. Xử lý tải file (Download) ---
    public function downloadIdea($id)
    {
        $idea = \App\Models\Idea::findOrFail($id);
        $path = storage_path('app/public/' . $idea->filePath);
        return response()->download($path);
    }

    // --- 3. ĐÃ BỔ SUNG LOGIC KHÓA VOTE CHẶT CHẼ ---
    public function react(Request $request, $id)
    {
        $idea = \App\Models\Idea::findOrFail($id);

        // KIỂM TRA DEADLINE: Lấy thời điểm 23:59:59 của ngày Chủ Nhật trong tuần mà bài được đăng
        $deadline = \Carbon\Carbon::parse($idea->created_at)->endOfWeek();

        // Nếu thời gian hiện tại đã vượt quá Deadline -> Báo lỗi chặn ngay lập tức
        if (now()->greaterThan($deadline)) {
            return response()->json(['message' => 'Thời gian vote cho bài viết này đã kết thúc vào Chủ Nhật vừa qua!'], 403);
        }

        $isUpvote = $request->action === 'upvote'; // true nếu bấm like, false nếu dislike
        $userId = Auth::id();

        $reaction = \App\Models\Reaction::where('ideaId', $id)->where('userId', $userId)->first();

        if ($reaction) {
            if ($reaction->is_upvote == $isUpvote) {
                $reaction->delete(); // Bấm lại lần 2 -> Hủy vote
            } else {
                $reaction->update(['is_upvote' => $isUpvote]); // Đổi từ like sang dislike và ngược lại
            }
        } else {
            \App\Models\Reaction::create([
                'ideaId' => $id,
                'userId' => $userId,
                'is_upvote' => $isUpvote
            ]); // Tạo vote mới
        }

        // Trả về số lượng mới để Javascript cập nhật giao diện
        $upvotes = \App\Models\Reaction::where('ideaId', $id)->where('is_upvote', true)->count();
        $downvotes = \App\Models\Reaction::where('ideaId', $id)->where('is_upvote', false)->count();

        return response()->json(['upvotes' => $upvotes, 'downvotes' => $downvotes]);
    }
}
