<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookGenre>
 */
class BookGenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BookGenre::class;
    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->first()->id ?? Book::factory()->create()->id,
            'genre_id' => Genre::inRandomOrder()->first()->id ?? Genre::factory()->create()->id
        ];
    }
}
