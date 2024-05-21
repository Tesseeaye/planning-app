<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Cards extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'position',
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(Lists::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): hasManyThrough
    {
        return $this->hasManyThrough(Attachments::class, User::class);
    }

    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comments::class, User::class);
    }
}