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
        Schema::rename('actors', 'creators');
        Schema::rename('actor_links', 'creator_links');
        Schema::table('creator_links', function (Blueprint $table) {
            $table->renameColumn('actor_id', 'creator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('creators', 'actors');
        Schema::rename('creator_links', 'actor_links');
        Schema::table('actor_links', function (Blueprint $table) {
            $table->renameColumn('creator_id', 'actor_id');
        });
    }
};
