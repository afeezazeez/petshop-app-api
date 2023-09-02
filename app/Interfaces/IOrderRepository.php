<?php

namespace App\Interfaces;

use App\Models\User;

interface IOrderRepository
{

    /**
     * @return  array<string,mixed>
     */
    public function fetchUserOrders();//: array;

}
