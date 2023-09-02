<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        User::factory()->create();
        OrderStatus::factory()->create();
        Payment::factory()->create();
        Product::factory(2)->create();
        $shipped_at = [null,now()];
        $total_amount = fake()->randomFloat(2,100,1000);
        $product1 = Product::InRandomOrder()->first();
        $product2 = Product::InRandomOrder()->where('id','!=',$product1->id ?? null)->first() ;


        $delivery_fee = $total_amount > 500 ? null : 15;
        return [
            'user_id'  =>User::InRandomOrder()->first()->id ?? null,
            'order_status_id' => OrderStatus::InRandomOrder()->first()->id ?? null,
            'payment_id'   => Payment::InRandomOrder()->first()->id ?? null,
            'products' => [
                ['product' =>$product1->uuid ?? null , 'quantity' => 3],
                ['product' =>$product2->uuid ?? null, 'quantity' => 2]
            ],
            'address'=>[
                'billing' => fake()->address(),
                'shipping'=>fake()->address()
            ],
            'amount' =>  $total_amount ,
            'delivery_fee' => $delivery_fee,
           'shipped_at'  => fake()->randomElement($shipped_at)
        ];
    }
}
