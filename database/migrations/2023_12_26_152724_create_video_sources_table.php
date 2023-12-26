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
        Schema::create('video_sources', function (Blueprint $table) {
            $table->id();
            $table->char('language', 2);
            $table->foreignUlid('video_id')->constrained('videos')->onDelete('cascade');
            $table->unsignedMediumInteger('duration');

            $table->string('thumbnail_path');
            $table->string('source_path');

            $table->unique(['video_id', 'language']);
            $table->index(['video_id', 'language']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_sources');
    }
};
