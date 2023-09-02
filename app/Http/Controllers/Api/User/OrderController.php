<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }




    /**
     * @OA\GET(
     *     path="/api/v1/user/orders",
     *     tags={"User Api Endpoints"},
     *     summary="Fetch User Orders",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="page",in="query",
     *         @OA\Schema(type="integer"),
     *         style="form" ),
     *     @OA\Parameter(name="limit",in="query",
     *         @OA\Schema(type="integer"),
     *         style="form"),
     *     @OA\Parameter(name="sortBy",in="query",
     *         @OA\Schema(type="string"),
     *         style="form"),
     *     @OA\Parameter(name="desc",in="query",
     *         @OA\Schema(type="boolean"),
     *         style="form"),
     *
     *     @OA\Response(response=200,description="OK"),
     *     @OA\Response(response=401,description="Unauthorized"),
     *     @OA\Response(response=404,description="Page not found"),
     *     @OA\Response(response=422,description="Unprocessable Entity"),
     *     @OA\Response(response=500,description="Internal server error")
     * )
     *
     * @return LengthAwarePaginator<Order>
     */

    public function index(): LengthAwarePaginator
    {
        $page  = request()->page ?? 1;
        $limit = request()->limit ?? config('app.default_pagination');
        $orders =   $this->orderService->fetchUserOrders();
        $items = collect($orders);
        return new LengthAwarePaginator(
            $items->forPage($page, $limit),
            $items->count(),
            $limit,
            $page,
            ['path' => request()->url()]
        );

    }

}
