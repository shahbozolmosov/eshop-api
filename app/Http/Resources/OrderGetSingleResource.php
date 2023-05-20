<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderGetSingleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'products' => ProductResource::collection($this->products),
            'address' => json_decode($this->address),
            'total_price' => $this->total_price,
            'created_at' => $this->created_at->isoFormat('MMM, D YYYY'),
            'updated_at' => $this->updated_at->isoFormat('MMM, D YYYY'),
        ];
    }
}
