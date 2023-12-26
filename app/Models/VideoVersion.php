<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoVersion extends Model
{
    use HasFactory;

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
