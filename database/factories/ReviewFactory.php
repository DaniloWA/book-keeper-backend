<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Review::class;
    public function definition(): array
    {
            return [
                'user_id' => $this->faker->numberBetween(1, 1),
                'book_id' => $this->faker->numberBetween(1, 1),
                'title' => $this->faker->sentence(),
                'content' => $this->faker->paragraph(),
        ];
    }
}
