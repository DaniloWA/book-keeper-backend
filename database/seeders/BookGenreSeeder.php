<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Could use chunk method here to avoid memory issues
        $books = Book::all();

        foreach ($books as $book) {
            BookGenre::factory()->count(rand(1, 3))->create([
                'book_id' => $book->id
            ]);
        }
    }
}
