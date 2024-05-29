<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lists extends Model
{
    use HasFactory, Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'name',
        'board_id',
        'user_id',
        'position',
        'slug',
    ];

    /**
     *
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function sluggableEvent(): string
    {
        return SluggableObserver::SAVED;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cards(): HasMany {
        return $this->hasMany(Card::class);
    }
}
