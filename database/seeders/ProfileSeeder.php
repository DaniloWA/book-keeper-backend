<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // EFFICIENT WAY

        if (User::count() === 0) {
            User::factory()->count(10)->withProfile()->create();
        } else {
            $userIdsWithProfile = User::has('profile')->pluck('id');
            $usersWithoutProfile = User::whereNotIn('id', $userIdsWithProfile)->get();

            foreach ($usersWithoutProfile as $user) {
                Profile::factory()->setUser($user)->create();
            }
        }

        // LESS EFFICIENT WAY
        // $users = User::all();

        // if ($users->isEmpty()) {
        //     $users = User::factory()->count(10)->create();
        // }

        // foreach ($users as $user) {
        //     $profile = Profile::where('user_id', $user->id)->exists();

        //     if (!$profile) {
        //         Profile::factory()->setUser($user)->create();
        //     }
        // }
    }
}
