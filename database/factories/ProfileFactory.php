<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Profile::class;

    private $user;

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function definition(): array
    {
        return [
            'user_id' => $this->user ? $this->user->id : function () {
                return User::factory()->create()->id;
            },
            'bio' => $this->faker->text(200),
            'avatar' => $this->faker->imageUrl(640, 480, 'avatar'),
            'instagram' => 'https://instagram.com/' . $this->faker->userName,
            'facebook' => 'https://facebook.com/' . $this->faker->userName,
            'twitter' => 'https://twitter.com/' . $this->faker->userName,
            'is_public' => $this->faker->boolean,
        ];
    }
}
