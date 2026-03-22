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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            // Liên kết với bảng ideas và users
            $table->unsignedBigInteger('ideaId');
            $table->unsignedBigInteger('userId');
            // Loại vote: 1 là Thumbs Up, 0 là Thumbs Down
            $table->boolean('is_upvote');
            $table->timestamps();

            // Đảm bảo 1 user chỉ có 1 record vote cho 1 idea
            $table->unique(['ideaId', 'userId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
