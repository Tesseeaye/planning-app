<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected function casts(): array {
        return [
            'user_id' => 'int',
        ];
    }

    /**
     * Kanban boards belong to a single author.
     */
    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lists(): HasMany
    {
        return $this->hasMany(Lists::class);
    }

    public function cards(): HasManyThrough
    {
        return $this->hasManyThrough(Card::class, Lists::class);
    }

    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Card::class);
    }

    public function attachments(): HasManyThrough
    {
        return $this->hasManyThrough(Attachment::class, Card::class);
    }
}