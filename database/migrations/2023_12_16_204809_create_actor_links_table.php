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
        Schema::create('actor_links', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('actor_id')->constrained('actors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('target');
            $table->char('letter', 1)->nullable();
            $table->char('background_color_hex', 7)->default('#000000');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_links');
    }
};
