<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'position' => $this->position,
            'list' => [
                'name' => $this->list->name,
                'slug' => $this->list->slug,
            ],
            'author' => [
                'name' => $this->author->name,
                'email' => $this->author->email,
            ]
        ];
    }
}
