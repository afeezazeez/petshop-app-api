<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'=>$this['product']['uuid'],
            'price'=>$this['product']['price'],
            'quantity'=>$this['quantity'],
            'product'=>$this['product']['title']
        ];
    }
}
