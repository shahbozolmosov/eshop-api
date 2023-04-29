<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

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
            'created_at' => $this->when(
                (isset($request->user()->name)
                    ? $request->user()->isAdmin()
                    : false
                ),
                $this->created_at->format('d/m/Y')
            ),
            'updated_at' => $this->when(
                (isset($request->user()->name)
                    ? $request->user()->isAdmin()
                    : false
                ),
                $this->updated_at->format('d/m/Y')
            ),
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
