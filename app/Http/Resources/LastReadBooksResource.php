<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LastReadBooksResource extends JsonResource
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
            'book' => $this->book ? [
                'uuid' => $this->book->uuid,
                'name' => $this->book->name,
                'year' => $this->book->year,
                'image' => $this->book->cover_img,
                'pages' => $this->book->pages,
                'average_rating' => $this->book->average_rating,
                'description' => $this->book->description,
                'author' => $this->book->author ? [
                    'id' => $this->book->author->id,
                    'first_name' => $this->book->author->first_name,
                    'last_name' => $this->book->author->last_name,
                    'bio' => $this->book->author->bio,
                    'avatar' => $this->book->author->avatar,
                ] : [],
            ] : [],
        ];
    }
}
