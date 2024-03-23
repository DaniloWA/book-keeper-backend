<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Statistics extends Model
{
    use HasFactory;

    protected $table = 'statistics';

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'liked',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'book_id' => 'integer',
            'status' => 'string',
            'liked' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    /**
     * Scope a query to only include statistics for the current authenticated user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
};
