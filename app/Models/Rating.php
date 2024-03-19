<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating';

    protected $fillable = [
        'id',
        'user_id',
        'book_id',
        'score'
    ];

        /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
        'user_id' => 'integer',
        'book_id' => 'integer',
        'score' => 'integer'
            
        ];
    }

    public function user()
    {
     return $this->belongsTo(User::class, 'user_id', 'id');   
    }

    public function book()
    {
     return $this->belongsTo(Book::class, 'books_id', 'id');   
    }
 
}
