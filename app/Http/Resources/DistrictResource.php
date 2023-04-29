<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
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
}
