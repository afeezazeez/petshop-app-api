<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Order extends Model
{
    use HasFactory, UUID;

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
        'address' => 'json'
    ];

    /**
     * @return BelongsTo<User, Order>
     *
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * @return BelongsTo<OrderStatus, Order>
     *
     */
    public function order_status(): BelongsTo
    {
        return $this->BelongsTo(OrderStatus::class);
    }

    /**
     * @return BelongsTo<Payment, Order>
     *
     */
    public function payment(): BelongsTo
    {
        return $this->BelongsTo(Payment::class);
    }
}
