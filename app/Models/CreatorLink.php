<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreatorLink extends Model
{
    use HasFactory;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    protected $fillable = ['id', 'creator_id', 'name', 'target', 'letter', 'background_color_hex'];

    protected $visible = ['id', 'creator_id', 'name', 'target', 'letter', 'background_color_hex'];
}
