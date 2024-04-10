<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Author::class;
    public function definition(): array
    {
        return [
            'first_name'=> $this->faker->firstName,
            'last_name'=> $this->faker->lastName,
            'bio'=> $this->faker->paragraph,
            'avatar'=> $this->faker->imageUrl(),
        ];
    }
}
