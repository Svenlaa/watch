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
        Schema::table('videos', function (Blueprint $table) {
            $table->char('language', 2)->after('title')->nullable();
            $table->foreignUlid('creator_id')->after('release_date')->constrained('creators')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dropColumn('thumbnail_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('thumbnail_path')->after('title');
            $table->dropColumn('language');
            $table->dropConstrainedForeignId('creator_id');
        });
    }
};
