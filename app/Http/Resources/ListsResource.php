<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListsResource extends JsonResource
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
            'board' => [
                'id' => $this->board->id,
                'name' => $this->board->name,
                'slug' => $this->board->slug,
            ],
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
            ],
        ];
    }
}
