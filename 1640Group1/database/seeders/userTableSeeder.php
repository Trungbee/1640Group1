<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin'), 'role' => 'admin', 'acceptTerms' => true],
            ['name' => 'staff', 'email' => 'staff1@gmail.com', 'password' => Hash::make('staff'), 'role' => 'staff', 'acceptTerms' => true],
        ]);
        DB::table('users')->insert([
            ['name' => 'staff2', 'email' => 'staff2@gmail.com', 'password' => Hash::make('staff2'), 'role' => 'staff', 'acceptTerms' => true, 'favorite_animal' => 'dog', 'favorite_color' => 'white', 'child_birth_year' => '2000']
        ]);
    }
}
