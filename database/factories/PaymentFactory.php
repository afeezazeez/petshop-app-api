<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'credit_card',
            'details' => [
                "holder_name" => fake()->name(),
                "number" => fake()->creditCardNumber(),
                "ccv" => 653,
                "expire_date" => fake()->creditCardExpirationDateString()
            ]
        ];
    }
}
