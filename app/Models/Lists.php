<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Lists extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Boards::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards(): HasMany {
        return $this->hasMany(Cards::class);
    }
}