<?php

use App\Models\Video;
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
        Schema::table('video_versions', function (Blueprint $table) {
            $table->date('release_date')->after('language')->nullable();
        });

        foreach (Video::all() as $video) {
            foreach ($video->videoVersions as $version) {
                $version->release_date = $video->release_date;
                $version->save();
            }
        }

        Schema::table('video_versions', function (Blueprint $table) {
            $table->date('release_date')->after('language')->change();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('release_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->date('release_date')->after('language')->nullable();
        });

        foreach (Video::all() as $video) {
            $version = $video->videoVersions()->orderBy('release_date')->first();
            $video->release_date = $version->release_date;
            $video->save();
        }

        Schema::table('videos', function (Blueprint $table) {
            $table->date('release_date')->change();
        });

        Schema::table('video_versions', function (Blueprint $table) {
            $table->dropColumn('release_date');
        });
    }
};
