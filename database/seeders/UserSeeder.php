<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use App\Models\Profile;
use App\Models\Statistic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds. statistic statistics
     */
    public function run(): void
    {
        $books = Book::all();

        User::factory()->withProfile()->count(10)->create()->each(function ($user) use ($books) {
            foreach ($books as $book) {
                $statistic = Statistic::factory()->make([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                ]);
                $user->statistics()->save($statistic);
            }

            $reviewCount = rand(1, 10);
            $booksForReview = $books->random($reviewCount);

            foreach ($booksForReview as $book) {
                $review = Review::factory()->make([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                ]);
                $user->reviews()->save($review);
            }
        });

        if (!User::where('email', 'Admin@gmail.com')->exists()) {
            $admin = User::factory()->withProfile()->create([
                'email' => 'Admin@gmail.com',
                'password' => bcrypt('Admin123'),
                'first_name' => 'Admin',
                'last_name' => 'Boss',
                'username' => 'AdminUserName',
            ]);
        }
    }
}
