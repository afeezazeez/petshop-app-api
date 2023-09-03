<?php

namespace App\Repositories;

use App\Filters\ModelsFilter;
use App\Http\Resources\OrderResource;
use App\Interfaces\IOrderRepository;
use App\Models\Order;
use Illuminate\Routing\Pipeline;

class OrderRepository implements IOrderRepository
{
    protected Order $model;


    public function __construct(Order $model)
    {
        $this->model = $model;

    }

    /**
     * Fetch user orders
     *
     * @@return array<string, mixed>
     */
    public function fetchUserOrders(): array
    {
        $query = Order::query();
        $orders = app(Pipeline::class)
            ->send($query)
            ->through([ModelsFilter::class])
            ->via('process')
            ->thenReturn()
            ->with(['order_status', 'user', 'payment'])
            ->where('user_id', auth()->id())
            ->get();

        return OrderResource::collection($orders)->resolve();

    }


}
