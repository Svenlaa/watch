<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Creator extends Model
{
    use HasFactory, HasUlids;

    public function creatorLinks(): HasMany
    {
        return $this->hasMany(CreatorLink::class, 'creator_id');
    }

    protected $visible = ['id', 'name', 'avatar_path'];
}
