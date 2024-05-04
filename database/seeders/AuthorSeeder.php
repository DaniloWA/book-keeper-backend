<?php

namespace Database\Seeders;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use PharIo\Manifest\Author as ManifestAuthor;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Author::factory()->count(8)->create();


       Author::factory()->male()->create();
       Author::factory()->female()->create();



    }
}
