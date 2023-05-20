<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $orderStatus = [
            [
                "status" => 'packing',
            ],
            [
                "status" => 'shipping',
            ],
            [
                "status" => 'arriving',
            ],
            [
                "status" => 'success',
            ],
        ];

        collect($orderStatus)->map(function ($item) {
            OrderStatus::create($item);
        });
    }
}
