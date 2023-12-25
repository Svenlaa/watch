<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CreatorController extends Controller
{
    public function index()
    {
        $creators = Creator::all();

        return view('creator.index', compact('creators'));
    }

    public function show(Request $request, Creator $creator)
    {
        return view('creator.show', compact('creator'));
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

        $creator = new Creator();
        $creator->name = $validated['name'];
        $creator->avatar_path = $filepath;
        $creator->save();

        return redirect()->route('creator.show', ['creator' => $creator->id])->with('success', 'Creator created successfully');
    }
}
