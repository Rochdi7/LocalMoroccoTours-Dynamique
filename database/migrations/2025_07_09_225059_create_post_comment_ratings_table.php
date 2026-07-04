<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_comment_ratings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_comment_id')
                ->constrained('post_comments')
                ->onDelete('cascade');

            $table->foreignId('rating_category_id')
                ->constrained('rating_categories')
                ->onDelete('cascade');

            $table->decimal('score', 3, 1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comment_ratings');
    }
};
