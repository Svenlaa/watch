<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\CreatorLink;
use Illuminate\Http\Request;

class CreatorLinkController extends Controller
{
    public function store(Request $request, Creator $creator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target' => 'required|url|max:255',
            'letter' => 'nullable|string|max:1',
            'background_color_hex' => 'nullable|hex_color',
        ]);

        $creatorLink = new CreatorLink();
        $creatorLink->creator_id = $creator->id;
        $creatorLink->name = $validated['name'];
        $creatorLink->target = $validated['target'];
        $creatorLink->letter = $validated['letter'] ?? $validated['name'][0];
        $creatorLink->background_color_hex = $validated['background_color_hex'] ?? null;
        $creatorLink->save();

        return redirect()->route('creator.show', ['creator' => $creator])->with('success', 'Creator link created successfully.');
    }
}
