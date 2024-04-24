<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'author_id' => Author::factory()->create()->id,
            'uuid' => (string) Str::uuid(),
            'name' => $this->faker->sentence(3),
            'year' => $this->faker->year,
            'cover_img' => $this->faker->imageUrl(),
            'pages' => $this->faker->randomNumber(3, true),
            'description' => $this->faker->paragraph,
        ];
    }
}
