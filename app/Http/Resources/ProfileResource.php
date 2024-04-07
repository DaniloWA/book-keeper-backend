<?php

namespace App\Http\Resources;

class ProfileResource extends ApiResponse
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'username' => $this->user->username,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'slug' => $this->user->slug,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'is_public' => $this->is_public,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
