<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use App\Models\Statistics;
use App\Exceptions\InvalidApiStatusException;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory class for generating Statistics model instances.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statistics>
 */
class StatisticsFactory extends Factory
{
    protected $model = Statistics::class;
    
    // User and Book variables to store the specified user and book
    private $user;
    private $book;

    /**
     * Set the user to be used in the factory.
     *
     * @param User $user The user to set
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Set the book to be used in the factory.
     *
     * @param Book $book The book to set
     * @return $this
     */
    public function setBook(Book $book)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->user ? $this->user->id : function () {
                return User::factory()->create()->id;
            },
            'book_id' => $this->book ? $this->book->id : function () {
                return Book::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['read', 'reading', 'abandoned', 'want_to_read']),
            'liked' => $this->faker->boolean(),
        ];
    }

    /**
     * Indicate that the statistics is liked.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function liked()
    {
        return $this->state(fn (array $attributes) => ['liked' => true]);
    }

    /**
     * Indicate that the statistics is unliked.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unLiked()
    {
        return $this->state(fn (array $attributes) => ['liked' => false]);
    }

    /**
     * Indicate that the statistics status is 'read'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function read()
    {
        return $this->state(fn (array $attributes) => ['status' => 'read']);
    }

    /**
     * Indicate that the statistics status is 'reading'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function reading()
    {
        return $this->state(fn (array $attributes) => ['status' => 'reading']);
    }

    /**
     * Indicate that the statistics status is 'abandoned'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function abandoned()
    {
        return $this->state(fn (array $attributes) => ['status' => 'abandoned']);
    }

    /**
     * Indicate that the statistics status is 'want_to_read'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function wantToRead()
    {
        return $this->state(fn (array $attributes) => ['status' => 'want_to_read']);
    }
}
