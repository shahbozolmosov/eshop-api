<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class OrderProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => new CategoryResource($this->category),
            'name' => $this->name,
            'price' => $this->pivot->price,
            'description' => $this->description,
            'order_qty' => $this->pivot->qty,
            'images' => $this->getImages($this->images),
        ];
    }

    public function getImages($images): Collection
    {
        return collect($images)->map(function ($image) {
            if (str_contains($image->url, 'http')) return $image->url;
            return asset('/storage/' . $image->url);
        });
    }
}
