<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Statistics;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user and a book
        $user = User::factory()->create();
        $books = Book::factory(10)->create();

        // Get a specified user from the database
        // $user = User::where('id', 225)->first();

        // Create a Statistics record with default values
        $statistics = Statistics::factory(30)->create();

        // Create a Statistics record with a specified user and book
        $statisticsWithUserAndBook = Statistics::factory()
            ->setUser($user)
            ->setBook($books->random()->first())
            ->create();

        // Create a liked Statistics record
        $likedStatistics = Statistics::factory(5)
            ->setBook($books->random()->first())
            ->liked()
            ->create();

        // Create an unliked Statistics record
        $unlikedStatistics = Statistics::factory(5)
            ->setBook($books->random()->first())
            ->unliked()
            ->create();

        // Create a read Statistics record
        $readStatistics = Statistics::factory(5)
            ->setBook($books->random()->first())
            ->read()
            ->create();

        // Create a reading Statistics record
        $readingStatistics = Statistics::factory(5)
            ->setBook($books->random()->first())
            ->reading()
            ->create();

        // Create an abandoned Statistics record
        $abandonedStatistics = Statistics::factory(5)
            ->setBook($books->random()->first())
            ->abandoned()
            ->create();

        // Create a want_to_read Statistics record
        $wantToReadStatistics = Statistics::factory(5)
            ->setBook($books->random()->first())
            ->wantToRead()
            ->create();

        // Create a mixed Statistics record
        $mixedStatistics = Statistics::factory(2)
            ->setBook($books->random()->first())
            ->unliked()
            ->abandoned()
            ->create();
    }
}
