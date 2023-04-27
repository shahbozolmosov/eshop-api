<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => new CategoryResource($this->category),
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'qty_left' => $this->stock->qty_left,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
