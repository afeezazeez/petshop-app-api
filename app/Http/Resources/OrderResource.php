<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->user){
            $this->user->makeHidden(['id','is_admin']) ?? null;
        }
        $this->payment->makeHidden(['id']);

        $productUuids = array_unique(array_column($this->products, 'product'));
        $products = Product::whereIn('uuid', $productUuids)->get();

        $productCollection = collect($this->products)->map(function ($item) use ($products) {
            $product = $products->firstWhere('uuid', $item['product']);
            return [
                'product' => $product,
                'quantity' => $item['quantity'],
            ];
        });


        return [
            'uuid'=> $this->uuid ?? null,
            'products'=>ProductResource::collection($productCollection),
            'address' => $this->address ?? null,
            'delivery_fee' => $this->delivery_fee ?? null,
            'amount' => $this->amount ?? null ,
            'created_at' => $this->created_at ?? null,
            'updated_at'=> $this->updated_at ?? null,
            'shipped_at'=>$this->shipped_at ?? null,
            'order_status'=> OrderStatusResource::make($this->order_status??null),
            'user'=>$this->user ?? null,
            'payment'=>$this->payment ?? null


        ];
    }
}
