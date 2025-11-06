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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('blog_categories')->onDelete('set null');
            $table->string('title_tr');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->text('excerpt_tr')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->text('content_tr'); // Markdown content
            $table->text('content_en'); // Markdown content
            $table->string('featured_image')->nullable();
            $table->string('meta_title_tr')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_tr')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->string('meta_keywords_tr')->nullable();
            $table->string('meta_keywords_en')->nullable();
            $table->integer('reading_time')->nullable(); // in minutes
            $table->integer('view_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
