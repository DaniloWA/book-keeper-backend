<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() === 0) {
            User::factory()->count(10)->create();

            User::factory()->create([
                'email' => 'Admin@gmail.com',
                'password' => 'Admin123',
                'first_name' => 'Admin',
                'last_name' => 'Boss',
                'username' => 'AdminUserName',
            ]);
        }
    }
}
