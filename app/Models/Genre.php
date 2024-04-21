<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';

    protected $fillable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string'
        ];
    }

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at'
    ];

    public function books()
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'genre_id', 'book_id');
    }
}
