<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
    ];

    public function card(): BelongsTo {
        return $this->belongsTo(Card::class);
    }

    public function author(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
