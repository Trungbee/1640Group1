<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'username' => 'admin_test',
            'fullName' => 'System Administrator',
            'email' => 'admin@test.com',
            'passwordHash' => Hash::make('123456'),
            'role' => 'Admin',
            'isActive' => true,
            'acceptTerms' => true,
        ]);

        // 2. Staff mẫu
        User::create([
            'username' => 'staff_test',
            'fullName' => 'John Staff',
            'email' => 'staff@test.com',
            'passwordHash' => Hash::make('123456'),
            'role' => 'Staff',
            'isActive' => true,
            'acceptTerms' => true,
        ]);

        // 3. Staff đã có bảo mật sẵn
        User::create([
            'username' => 'staff2',
            'fullName' => 'Jane Staff',
            'email' => 'staff2@gmail.com',
            'passwordHash' => Hash::make('123456'),
            'role' => 'Staff',
            'isActive' => true,
            'acceptTerms' => true,
            'favorite_animal' => 'dog',
            'favorite_color' => 'white',
            'child_birth_year' => '2000'
        ]);
    }
}
