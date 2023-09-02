<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'is_admin'  => fake()->randomElement([1,0]),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'userpassword',
            'avatar'   => fake()->uuid(),
            'address'  => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'is_marketing' => fake()->randomElement([1,0]),
            'last_login_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
