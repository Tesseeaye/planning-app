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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'position' => $this->position,
            'list' => [
                'id' => $this->list->id,
                'name' => $this->list->name,
                'slug' => $this->list->slug,
            ],
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
            ]
        ];
    }
}
