<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actor extends Model
{
    use HasFactory, HasUlids;

    public function actorLinks(): HasMany
    {
        return $this->hasMany(ActorLink::class, 'actor_id');
    }

    protected $visible = ['id', 'name', 'avatar_path'];
}
