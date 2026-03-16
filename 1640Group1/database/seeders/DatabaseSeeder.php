<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Bơm dữ liệu theo thứ tự: Môn học trước, User sau
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
        ]);
    }
}
