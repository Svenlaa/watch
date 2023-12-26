<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\Video;
use App\Models\VideoSource;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        $creators = Creator::select(['id', 'name'])->get();

        return view('videos.index', compact('videos', 'creators'));
    }

    public function show(Request $request, Video $video)
    {
        abort(501);

        return view('videos.show', compact('video'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:1',
            'release_date' => 'required|date',
            'language' => 'required|min:2',
            'creator_id' => 'required|exists:creators,id',
            'thumbnail' => 'required|image|dimensions:min_width=100,ratio=16/9',
            'video' => 'required|file',
        ]);

        $video = new Video();
        $video->title = $validated['title'];
        $video->release_date = $validated['release_date'];
        $video->creator_id = $validated['creator_id'];
        $video->language = strtolower($validated['language']);
        $video->save();

        $thumbnail = Image::make($validated['thumbnail'])->resize(800, 450)->encode('webp', 75)->stream();
        $thumbnailPath = 'thumbnails/'.Str::ulid().'.webp';
        Storage::put($thumbnailPath, $thumbnail->__toString());

        $getID3 = new getID3();
        $videoInfo = $getID3->analyze($validated['video']);

        $videoPath = Storage::put('videos', $validated['video']);

        $videoSource = new VideoSource();
        $videoSource->video_id = $video->id;
        $videoSource->language = $video->language;
        $videoSource->source_path = $videoPath;
        $videoSource->thumbnail_path = $thumbnailPath;
        $videoSource->duration = (int) $videoInfo['playtime_seconds'];
        $videoSource->save();

        return redirect()->route('video.show', ['video' => $video->id])->with('success', 'Video created successfully');
    }
}
