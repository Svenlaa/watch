<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory, HasUlids;

    protected $visible = ['id', 'title', 'release_date', 'language', 'creator_id'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function videoVersions(): HasMany
    {
        return $this->hasMany(VideoVersion::class, 'video_id');
    }

    public function getVideoVersion(?string $language = null): VideoVersion|Model|null
    {
        $versions = $this->videoVersions;

        return $versions->firstWhere('language', $language ?? $this->language) ?: $versions->firstWhere('language', $this->language) ?: $versions->first();
    }
}
