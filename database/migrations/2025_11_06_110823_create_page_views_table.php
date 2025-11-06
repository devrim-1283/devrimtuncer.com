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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('page_path');
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('language')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();
            
            $table->index(['page_path', 'ip_address', 'viewed_at']);
            $table->index('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
