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

    public function videoSources(): HasMany
    {
        return $this->hasMany(VideoSource::class, 'video_id');
    }

    public function getVideoSource(?string $language = null): ?VideoSource
    {
        return $this->videoSources()->firstWhere('language', $language ?? $this->language);
    }
}
