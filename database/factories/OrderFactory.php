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
        $user = User::factory()->create();
        $order_status =OrderStatus::factory()->create();
        $payment = Payment::factory()->create();
        $product1 =Product::factory()->create();
        $product2 =Product::factory()->create();
        $shipped_at = [null,now()];
        $total_amount = fake()->randomFloat(2,100,1000);


        $userModel = User::where('uuid', $user->uuid)->first();
        $user_id = $userModel ? $userModel->id : null;

        $orderStatusModel = User::where('uuid', $order_status->uuid)->first();
        $order_status_id = $orderStatusModel ? $orderStatusModel->id : null;

        $paymentModel = Payment::where('uuid', $payment->uuid)->first();
        $payment_id = $paymentModel ? $paymentModel->id : null;



        $delivery_fee = $total_amount > 500 ? null : 15;
        return [
            'user_id'  =>$user_id,
            'order_status_id' => $order_status_id,
            'payment_id'   => $payment_id,
            'products' => [
                ['product' =>$product1->uuid , 'quantity' => 3],
                ['product' =>$product2->uuid, 'quantity' => 2]
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
