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
            'name' => $this->name,
            'slug' => $this->slug,
            'board' => [
                'name' => $this->board->name,
                'slug' => $this->board->slug,
            ],
            'author' => [
                'name' => $this->author->name,
                'email' => $this->author->email,
            ],
        ];
    }
}