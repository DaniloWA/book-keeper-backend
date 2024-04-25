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
            'bio' => $this->faker->text(200),
            'avatar' => $this->faker->imageUrl(640, 480, 'avatar'),
            'instagram' => 'https://instagram.com/' . $this->faker->userName,
            'facebook' => 'https://facebook.com/' . $this->faker->userName,
            'twitter' => 'https://twitter.com/' . $this->faker->userName,
            'is_public' => $this->faker->boolean,
        ];
    }

    /**
     * Indicate that the profile should be public.
     */
    public function public(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_public' => true,
            ];
        });
    }

    /**
     * Indicate that the profile should be private.
     */
    public function private(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_public' => false,
            ];
        });
    }

    public function noAvatar(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'avatar' => null,
            ];
        });
    }

    public function noSocialLinks(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'instagram' => null,
                'facebook' => null,
                'twitter' => null,
            ];
        });
    }

    public function fullSocialLinks(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'instagram' => 'https://instagram.com/' . $this->faker->unique()->userName,
                'facebook' => 'https://facebook.com/' . $this->faker->unique()->userName,
                'twitter' => 'https://twitter.com/' . $this->faker->unique()->userName,
            ];
        });
    }
}
