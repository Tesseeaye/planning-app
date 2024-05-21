<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Boards extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Kanban boards belong to a single author.
     */
    public function author(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lists(): HasMany
    {
        return $this->hasMany(Lists::class);
    }

    public function cards(): HasManyThrough
    {
        return $this->hasManyThrough(Cards::class, Lists::class);
    }
}