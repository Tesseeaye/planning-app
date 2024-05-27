<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'position',
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(Lists::class, 'lists_id');
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
