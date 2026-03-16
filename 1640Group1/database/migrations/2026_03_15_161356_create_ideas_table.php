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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id('ideaId');
            $table->string('title');
            $table->text('description');
            $table->foreignId('userId')->constrained('users', 'userId'); // Người đăng (Staff)
            $table->foreignId('categoryId')->constrained('categories', 'categoryId'); // Thuộc danh mục nào
            $table->string('filePath'); // Đường dẫn file word/pdf lưu trên server
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
