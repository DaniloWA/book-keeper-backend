<?php

namespace App\Models;

use App\Models\Statistic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'uuid',
        'author_id',
        'name',
        'year',
        'cover_img',
        'pages',
        'description',
        'country',
        'average_rating',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'author_id' => 'integer',
            'name' => 'string',
            'year' => 'string',
            'cover_img' => 'string',
            'pages' => 'integer',
            'description' => 'string',
            'country' => 'string',
            'average_rating' => 'float',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'author_id',
        'id',
    ];


    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'book_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'book_id', 'id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id', 'id');
    }

    public function rate($score)
    {
        $this->ratings()->where('user_id', auth()->user()->id)->delete();

        $this->ratings()->create([
            'user_id' => auth()->user()->id,
            'score' => $score
        ]);

        $averageRating = $this->ratings()->avg('score');
        $roundedAverageRating = round($averageRating * 2) / 2;

        $this->update(['average_rating' => $roundedAverageRating]);
    }

    public function scopeWithGenres($query)
    {
        return $query->with([
            'genres' => function ($query) {
                $query->select('genres.id', 'genres.name');
            }
        ]);
    }

    public function scopeWithAuthor($query)
    {
        return $query->with('author:id,first_name,last_name');
    }

    public function scopeWithRatings($query)
    {
        return $query->withCount('ratings');
    }

    public function scopeWithStatistics($query)
    {
        return $query->with('statistics');
    }
}