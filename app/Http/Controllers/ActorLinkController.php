<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\ActorLink;
use Illuminate\Http\Request;

class ActorLinkController extends Controller
{
    public function store(Request $request, Actor $actor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target' => 'required|url|max:255',
            'letter' => 'nullable|string|max:1',
            'background_color_hex' => 'nullable|hex_color',
        ]);

        $actorLink = new ActorLink();
        $actorLink->actor_id = $actor->id;
        $actorLink->name = $validated['name'];
        $actorLink->target = $validated['target'];
        $actorLink->letter = $validated['letter'] ?? $validated['name'][0];
        $actorLink->background_color_hex = $validated['background_color_hex'] ?? null;
        $actorLink->save();

        return redirect()->route('actor.show', ['actor' => $actor])->with('success', 'Actor link created successfully.');
    }
}
