<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Idea;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // Bổ sung thư viện quản lý file

class IdeaSeeder extends Seeder
{
    public function run(): void
    {
        $staffIds = User::where('role', 'Staff')->pluck('userId')->toArray();
        $categoryIds = Category::pluck('categoryId')->toArray();

        if (empty($staffIds) || empty($categoryIds)) {
            return;
        }

        // --- MỚI: TẠO FILE VẬT LÝ THẬT ĐỂ TẢI XUỐNG ---
        // 1. Đảm bảo thư mục storage/app/public/ideas tồn tại
        if (!Storage::disk('public')->exists('ideas')) {
            Storage::disk('public')->makeDirectory('ideas');
        }

        // 2. Tạo một file giả lập thật sự trên ổ cứng
        $dummyContent = "Đây là tài liệu đính kèm giả lập (Dummy File) được hệ thống tự động sinh ra để test tính năng Download. Chúc bạn một ngày code vui vẻ!";
        Storage::disk('public')->put('ideas/sample_dummy.pdf', $dummyContent);
        // ---------------------------------------------

        $titles = [
            'Nâng cấp hệ thống wifi thư viện',
            'Ứng dụng AI vào giảng dạy',
            'Đề xuất không gian làm việc chung (Co-working space)',
            'Phần mềm điểm danh sinh viên tự động',
            'Tạo không gian xanh trong khuôn viên trường',
            'Khóa học kỹ năng mềm cho sinh viên IT',
            'Nâng cấp thiết bị phòng Lab',
            'Triển khai thùng rác phân loại thông minh',
            'Câu lạc bộ khởi nghiệp kinh doanh',
            'Cải thiện hệ thống mượn sách trực tuyến'
        ];

        foreach ($titles as $title) {
            Idea::create([
                'title' => $title,
                'description' => 'Đây là nội dung mô tả chi tiết cho ý tưởng: ' . $title . '. Giải pháp này sẽ mang lại giá trị lớn cho cộng đồng.',
                'categoryId' => $categoryIds[array_rand($categoryIds)],
                'userId' => $staffIds[array_rand($staffIds)],
                'filePath' => 'ideas/sample_dummy.pdf', // Đường dẫn này giờ đã có file thật tương ứng
                'created_at' => Carbon::now()->subDays(rand(0, 14))->subHours(rand(1, 23))
            ]);
        }
    }
}
