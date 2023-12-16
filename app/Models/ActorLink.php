<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActorLink extends Model
{
    use HasFactory;

    public function actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class);
    }

    protected $fillable = ['id', 'actor_id', 'name', 'target', 'letter', 'background_color_hex'];

    protected $visible = ['id', 'actor_id', 'name', 'target', 'letter', 'background_color_hex'];
}
