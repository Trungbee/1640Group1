<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Làm sạch bảng reactions trước khi nạp dữ liệu mới (Cú pháp PostgreSQL)
        // RESTART IDENTITY giúp reset các ID tự tăng về 1
        DB::statement('TRUNCATE TABLE reactions RESTART IDENTITY CASCADE');

        // 2. Lấy danh sách ID của tất cả Idea và User (Staff)
        $ideaIds = Idea::pluck('ideaId')->toArray();
        $userIds = User::pluck('userId')->toArray();
        $totalUsers = count($userIds);

        // Kiểm tra nếu chưa có dữ liệu thì dừng lại để tránh lỗi
        if (empty($ideaIds) || $totalUsers === 0) {
            $this->command->warn('No Ideas or Users found in database. Please seed them first.');
            return;
        }

        $this->command->info("Starting to seed reactions for $totalUsers users...");

        foreach ($ideaIds as $ideaId) {
            // 3. XỬ LÝ LOGIC SỐ LƯỢNG VOTE AN TOÀN:
            // Tối thiểu là 1 người vote, tối đa là 25 người (hoặc bằng tổng số User nếu ít hơn 25)
            $minVoters = 1;
            $maxVoters = min(25, $totalUsers);

            $voterCount = rand($minVoters, $maxVoters);

            // 4. Lấy ngẫu nhiên danh sách ID người dùng từ mảng $userIds
            // array_rand trả về 1 key (int) nếu $voterCount = 1, trả về 1 mảng (array) nếu > 1
            $randomKeys = array_rand(array_flip($userIds), $voterCount);

            // Ép kiểu về mảng để vòng lặp foreach luôn hoạt động chính xác
            $voterIds = is_array($randomKeys) ? $randomKeys : [$randomKeys];

            foreach ($voterIds as $voterId) {
                Reaction::create([
                    'ideaId'    => $ideaId,
                    'userId'    => $voterId,
                    // Tỷ lệ: 80% Upvote (true), 20% Downvote (false)
                    'is_upvote' => (rand(1, 10) <= 8)
                ]);
            }
        }

        $this->command->info("Success! ReactionSeeder has finished seeding.");
    }
}
