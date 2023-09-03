<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order_statuses = [
            'open',
            'pending payment',
            'paid',
            'shipped',
            'cancelled'
        ];

        foreach ($order_statuses as $order_status) {
            OrderStatus::create(['title' => $order_status]);
        }
    }
}
