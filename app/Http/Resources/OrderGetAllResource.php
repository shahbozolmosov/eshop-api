<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderGetAllResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => json_decode($this->address),
            'total_price' => $this->total_price,
            'products_count' => $this->products_count,
            'shipping_date' => Carbon::parse($this->shipping_date)->isoFormat('MMM, D YYYY'),
            'order_status' => $this->orderStatus->status,
            'created_at' => $this->created_at->isoFormat('MMM, D YYYY'),
            'updated_at' => $this->updated_at->isoFormat('MMM, D YYYY'),
        ];
    }
}
