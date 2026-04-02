<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Phải gọi theo đúng thứ tự: Tạo Tài khoản và Chuyên mục trước
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,

            // Đã xóa dấu // ở 2 dòng dưới để hệ thống kích hoạt việc tạo bài viết
            IdeaSeeder::class,
            ReactionSeeder::class,
        ]);
    }
}
