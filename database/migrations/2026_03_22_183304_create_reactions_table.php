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
            // Link table ideas & users
            $table->unsignedBigInteger('ideaId');
            $table->unsignedBigInteger('userId');
            // Vote type: 1 = Thumbs Up, 0 = Thumbs Down
            $table->boolean('is_upvote');
            $table->timestamps();

            // Each user can only have one vote record for one idea.
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
