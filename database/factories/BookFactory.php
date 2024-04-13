<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Book::class;
    public function definition(): array
    {
        $author = Author::inRandomOrder()->first() ?? Author::factory()->create();

        return [
            'uuid' => (string) Str::uuid(),
            'author_id' => $author->id,
            'name' => $this->faker->sentence(3),
            'year' => $this->faker->year,
            'genre' => $this->faker->word,
            'cover_img' => $this->faker->imageUrl(),
            'pages' => $this->faker->randomNumber(3, true),
            'description' => $this->faker->paragraph,
        ];
    }
}
