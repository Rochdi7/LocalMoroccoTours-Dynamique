<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->foreignId('parent_id')->nullable()->constrained('post_comments')->onDelete('cascade');

            $table->string('guest_name')->nullable();

            $table->string('guest_email')->nullable();

            $table->string('comment_title')->nullable();

            $table->text('comment_body');

            $table->decimal('rating', 3, 1)->nullable();

            $table->json('images')->nullable();

            $table->unsignedInteger('helpful_count')->default(0);

            $table->unsignedInteger('not_helpful_count')->default(0);

            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
