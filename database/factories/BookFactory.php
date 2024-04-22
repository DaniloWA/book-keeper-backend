<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
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
        return [
            'uuid' => (string) Str::uuid(),
            'author_id' => Author::inRandomOrder()->first()->id ?? Author::factory(),
            'name' => $this->faker->sentence(3),
            'year' => $this->faker->year,
            'cover_img' => $this->faker->imageUrl(),
            'pages' => $this->faker->randomNumber(3, true),
            'description' => $this->faker->paragraph,
            'country' => $this->faker->country,
        ];
    }

    public function withSpecificAttribute($attribute, $value): Factory
    {
        return $this->state(function (array $attributes) use ($attribute, $value) {
            return [
                $attribute => $value,
            ];
        });
    }

    public function withYearRange($min, $max): Factory
    {
        return $this->state(function (array $attributes) use ($min, $max) {
            return [
                'year' => $this->faker->numberBetween($min, $max),
            ];
        });
    }


    public function withPageRange($min, $max): Factory
    {
        return $this->state(function (array $attributes) use ($min, $max) {
            return [
                'pages' => $this->faker->numberBetween($min, $max),
            ];
        });
    }
}
