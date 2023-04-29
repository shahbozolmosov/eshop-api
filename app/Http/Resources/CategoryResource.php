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
            'name' => $this->name,
            'image' => $this->images->isNotEmpty() ? asset('/storage/'.$this->images[0]->url):'',
            'parent_id' => $this->parent_id ?? null,
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

        if($this->children)
            $response['children'] = CategoryResource::collection($this->children);

        return $response;
    }
}
