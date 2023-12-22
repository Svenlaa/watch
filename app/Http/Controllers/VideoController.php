<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();

        return view('videos.index', compact('videos'));
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
            'thumbnail' => 'required|file|image|dimensions:min_width=100,ratio=16/9',
            'release_date' => 'required|date',
        ]);

        $image = Image::make($validated['thumbnail'])->resize(1600, 900)->encode('webp', 75)->stream();

        $filepath = 'thumbnails/'.Str::ulid().'.webp';

        Storage::put($filepath, $image->__toString());

        $video = new Video();
        $video->title = $validated['title'];
        $video->release_date = $validated['release_date'];
        $video->thumbnail_path = $filepath;
        $video->save();

        return redirect()->route('video.show', ['video' => $video->id])->with('success', 'Video created successfully');
    }
}
