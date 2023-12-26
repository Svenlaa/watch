<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoVersion;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VideoVersionController extends Controller
{
    public function create(Request $request, Video $video)
    {
        $validated = $request->validate([
            'language' => 'required|min:2',
            'thumbnail' => 'required|image|dimensions:min_width=100,ratio=16/9',
            'video' => 'required|file',
            'release_date' => 'required|date',
        ]);

        $video->language = $validated['language'];
        self::save($video, $validated['thumbnail'], $validated['video'], $validated['release_date']);

        return to_route('video', ['video' => $video, 'language' => $video->language]);
    }

    public static function save(Video $video, UploadedFile $vThumbnail, UploadedFile $vVideo, string $vReleaseDate)
    {

        dump($vThumbnail, $vVideo, $vReleaseDate);
        $thumbnail = Image::make($vThumbnail)->resize(800, 450)->encode('webp', 75)->stream();
        $thumbnailPath = 'thumbnails/'.Str::ulid().'.webp';
        Storage::put($thumbnailPath, $thumbnail->__toString());

        $getID3 = new getID3();
        $videoInfo = $getID3->analyze($vVideo);

        $videoPath = Storage::put('videos', $vVideo);

        $videoVersion = new VideoVersion();
        $videoVersion->video_id = $video->id;
        $videoVersion->language = $video->language;
        $videoVersion->release_date = $vReleaseDate;
        $videoVersion->source_path = $videoPath;
        $videoVersion->thumbnail_path = $thumbnailPath;
        $videoVersion->duration = (int) $videoInfo['playtime_seconds'];
        $videoVersion->save();
    }
}
