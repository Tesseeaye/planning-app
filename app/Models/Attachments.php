<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachments extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_type',
        'file_size',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Cards::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}