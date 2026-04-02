<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Lưu câu hỏi bảo mật đang được kích hoạt (favorite_animal | favorite_color | child_birth_year)
            $table->string('active_security_question')->nullable()->after('child_birth_year');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active_security_question');
        });
    }
};
