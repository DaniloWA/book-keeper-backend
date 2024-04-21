<?php

namespace App\Http\Resources;

class BookResource extends ApiResponse
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'year' => $this->year,
            'cover_img' => $this->cover_img,
            'pages' => $this->pages,
            'description' => $this->description,
            'genres' => $this->genres->map(function ($genre) {
                return [
                    'id' => $genre->id,
                    'name' => $genre->name
                ];
            }),
            'ratings_count' => $this->ratings()->count(),
            'author' => [
                'id' => $this->author->id,
                'first_name' => $this->author->first_name,
                'last_name' => $this->author->last_name,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
