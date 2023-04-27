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
            'images' => $this->getImages($this->images),
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }

    public function getImages($images)
    {
        return collect($images)->map(function ($image) {
            if (str_contains($image->url, 'http')) return $image->url;
            return asset('/storage/' . $image->url);
        });
    }
}
