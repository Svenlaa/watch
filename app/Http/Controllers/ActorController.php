<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Storage;
use Str;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::all();

        return view('actors.index', compact('actors'));
    }

    public function show(Request $request, Actor $actor)
    {
        return view('actors.show', compact('actor'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1',
            'avatar' => 'required|file|image|dimensions:min_width=100,ratio=1',
        ]);

        $image = Image::make($validated['avatar'])->resize(256, 256)->encode('webp', 75)->stream();

        $filepath = 'avatars/'.Str::ulid().'.webp';

        Storage::put($filepath, $image->__toString());

        $actor = new Actor();
        $actor->name = $validated['name'];
        $actor->avatar_path = $filepath;
        $actor->save();

        return redirect()->route('actor.show', ['actor' => $actor->id])->with('success', 'Actor created successfully');
    }
}
