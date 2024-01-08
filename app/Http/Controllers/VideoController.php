<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('videoVersions')->get();
        $creators = Creator::select(['id', 'name'])->get();

        return view('videos.index', compact('videos', 'creators'));
    }

    public function show(Request $request, Video $video, ?string $language = null)
    {
        $version = $video->getVideoVersion($language);
        if (! $version) {
            return to_route('video.show', compact('video'));
        }

        return view('videos.show', compact('video', 'version'));
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
        $video->creator_id = $validated['creator_id'];
        $video->language = strtolower($validated['language']);
        $video->save();

        VideoVersionController::save($video, $validated['thumbnail'], $validated['video'], $validated['release_date'], null);

        return redirect()->route('video.show', ['video' => $video->id])->with('success', 'Video added successfully');
    }
}
