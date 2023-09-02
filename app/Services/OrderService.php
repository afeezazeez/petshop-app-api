<?php

namespace App\Services;

use App\Interfaces\IOrderRepository;

class OrderService
{

    private IOrderRepository $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    /**
     * Fetch user orders
     *
     * @return  array<string,mixed>
     */
    public function fetchUserOrders(): array
    {
        return $this->orderRepository->fetchUserOrders();
    }
}
