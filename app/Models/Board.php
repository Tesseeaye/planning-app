<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Board extends Model
{
    use HasFactory, Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'name',
        'user_id',
        'slug',
    ];

    protected $with = [
        'author',
    ];

    /**
     *
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
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
}