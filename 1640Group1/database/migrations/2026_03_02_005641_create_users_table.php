<?php

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
    Schema::create('users', function (Blueprint $table) {
        $table->id('userId');
        $table->string('username')->unique();
        $table->string('fullName');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('passwordHash');
        $table->string('role');
        $table->boolean('acceptTerms')->default(true);
        $table->boolean('isActive')->default(true);

        // BỔ SUNG CÁC CỘT BẢO MẬT (Cho phép null để không lỗi khi tạo user mới)
        $table->string('favorite_animal')->nullable();
        $table->string('favorite_color')->nullable();
        $table->string('child_birth_year')->nullable();

        $table->rememberToken();
        $table->timestamps();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
