<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
            'file_size' => $this->file_size,
            'alt_text' => $this->alt_text,
            'card' => [
                'name' => $this->card->name,
                'slug' => $this->card->slug,
            ],
            'author' => [
                'name' => $this->author->name,
                'email' => $this->author->email,
            ]
        ];
    }
}