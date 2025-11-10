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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('content_id')->unique();
            $table->string('source')->nullable()->index();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->string('language', 10)->nullable()->index();
            $table->string('content_url')->nullable();
            $table->string('author')->nullable()->index();
            $table->string('category')->nullable()->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
