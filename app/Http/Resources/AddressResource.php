<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'regions' => new RegionResource($this->region),
            'district' => new DistrictResource($this->district),
            'street' => $this->street,
            'house' => $this->house,
            'apartment' => $this->apartment,
            'floor' => $this->floor,
            'is_default' => (bool)$this->pivot->is_default
        ];
    }
}
