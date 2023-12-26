<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\Video;
use Illuminate\Http\Request;

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
        ]);

        $video = new Video();
        $video->title = $validated['title'];
        $video->release_date = $validated['release_date'];
        $video->creator_id = $validated['creator_id'];
        $video->language = strtolower($validated['language']);
        $video->save();

        return redirect()->route('video.show', ['video' => $video->id])->with('success', 'Video created successfully');
    }
}
