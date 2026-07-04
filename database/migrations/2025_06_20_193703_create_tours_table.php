<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('overview');
            $table->text('highlights')->nullable();
            $table->string('duration');
            $table->string('group_size')->nullable();
            $table->string('age_range');
            $table->decimal('base_price', 10, 2);
            $table->boolean('bestseller_flag')->default(false);
            $table->boolean('free_cancellation_flag')->default(false);
            $table->integer('booked_count')->default(0);
            $table->longText('map_frame')->nullable();

            $table->decimal('rating', 2, 1)->default(5.0);
            $table->integer('reviews_count')->default(0);

            $table->json('included')->nullable();
            $table->json('excluded')->nullable();
            $table->json('itinerary')->nullable();
            $table->string('languages')->nullable();

            $table->foreignId('category_id')->constrained('tour_categories')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
