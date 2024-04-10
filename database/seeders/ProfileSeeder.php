<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->count(10)->create();
        }

        foreach ($users as $user) {
            $profile = Profile::where('user_id', $user->id)->exists();

            if (!$profile) {
                Profile::factory()->setUser($user)->create();
            }
        }
    }
}
