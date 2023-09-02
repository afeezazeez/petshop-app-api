<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory,UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_status_id',
        'payment_id',
        'product',
        'address',
        'delivery_fee',
        'amount',
        'shipped_at'
    ];


    protected $casts = [
        'products' => 'json',
        'address'  => 'json'
    ];
}
