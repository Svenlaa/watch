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

        $update = [
            'language' => $request->has('update_video_language'),
        ];

        self::save($video, $validated['thumbnail'] ?? null, $validated['video'], $validated['release_date'], $validated['language'], $update);

        return to_route('video.show', ['video' => $video, 'language' => $validated['language']]);
    }

    public static function save(Video $video, ?UploadedFile $vThumbnail, UploadedFile $vVideo, string $vReleaseDate, ?string $vLanguage, array $vUpdate = [])
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
        $videoVersion->language = $vLanguage ?? $video->language;
        $videoVersion->release_date = $vReleaseDate;
        $videoVersion->source_path = $videoPath;
        $videoVersion->thumbnail_path = $thumbnailPath;
        $videoVersion->duration = (int) $videoInfo['playtime_seconds'];
        $videoVersion->save();

        foreach ($vUpdate as $k => $v) {
            if ($v) {
                if (array_key_exists($k, $video->toArray()) && array_key_exists($k, $videoVersion->toArray())) {
                    $video[$k] = $videoVersion[$k];
                }
            }
        }

        if ($video->isDirty()) {
            $video->save();
        }
    }
}
