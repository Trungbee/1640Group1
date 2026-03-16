<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function home() {
    $categories = \App\Models\Category::all(); // Lấy tất cả môn học
    return view('staff.home', compact('categories'));
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

// app/Http/Controllers/StaffController.php

    public function storeIdea(Request $request)
    {
          // 1. Kiểm tra dữ liệu đầu vào (Đã đổi 'file' thành 'document')
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'document' => 'required|mimes:pdf,doc,docx|max:10240', // Bắt buộc có file, tối đa 10MB
        ]);

        // 2. Tạo Idea mới
        $idea = new \App\Models\Idea();
        $idea->title = $request->title;
        $idea->description = $request->description;
        $idea->categoryId = $request->category_id;
        $idea->userId = \Illuminate\Support\Facades\Auth::id(); // Lấy ID người đang đăng nhập

        // 3. Xử lý Upload File (Bắt đúng tên 'document')
        if ($request->hasFile('document')) {
            // Lưu file vào thư mục storage/app/public/ideas
            $path = $request->file('document')->store('ideas', 'public');
            $idea->filePath = $path;
        }

        // 4. Lưu vào Database
        $idea->save();

        // 5. Quay về trang chủ kèm thông báo thành công
        return redirect()->route('staff.home')->with('success', 'Idea submitted successfully!');
    }
}
