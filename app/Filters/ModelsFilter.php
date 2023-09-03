<?php

namespace App\Filters;

use App\Models\Order;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class ModelsFilter
{
    /**
     *
     * @param Builder<Order> $query
     * @return Builder<Order>
     */
    public function process(Builder $query, Closure $next): Builder
    {
        $sortBy = request()->sortBy ?? 'created_at';
        $desc = request()->desc ?? false;
        $query->orderBy($sortBy, $desc == "true" ? 'desc' : 'asc');
        if (request()->has('first_name')) {
            $query->where('first_name', 'LIKE', '%' . request('first_name') . '%');
        }
        if (request()->has('email')) {
            $query->where('email', request('email'));
        }
        if (request()->has('phone')) {
            $query->where('phone_number', request('phone'));
        }
        if (request()->has('address')) {
            $query->where('address', 'LIKE', '%' . request('address') . '%');
        }
        if (request()->has('created_at')) {
            $query->whereDate('created_at', request('created_at'));
        }
        return $next($query);
    }
}
