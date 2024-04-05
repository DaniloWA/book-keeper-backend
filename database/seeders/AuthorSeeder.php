<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Author::factory()->count(10)->create();
    }
}
