<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('commentId'); // Dùng commentId cho đồng bộ với ideaId, userId
            $table->unsignedBigInteger('ideaId');
            $table->unsignedBigInteger('userId');
            $table->text('content');
            $table->boolean('is_anonymous')->default(false); // Cột ẩn danh
            $table->timestamps();

            // Ràng buộc khóa ngoại (Xóa idea hoặc user thì comment cũng tự động mất)
            $table->foreign('ideaId')->references('ideaId')->on('ideas')->onDelete('cascade');
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
