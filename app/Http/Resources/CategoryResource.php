<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'title' => $this->name,
            'parent_id' => $this->parent_id ?? null,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];

        if($this->children)
            $response['children'] = CategoryResource::collection($this->children);

        return $response;
    }
}
