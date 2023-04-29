<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $carts = [
            [
                'user_id' => 2,
                'product_id' => 1,
                'qty' => rand(1, 10),
            ],
            [
                'user_id' => 2,
                'product_id' => 2,
                'qty' => rand(1, 10),
            ],
            [
                'user_id' => 2,
                'product_id' => 3,
                'qty' => rand(1, 10),
            ],
            [
                'user_id' => 2,
                'product_id' => 4,
                'qty' => rand(1, 10),
            ],
            [
                'user_id' => 2,
                'product_id' => 5,
                'qty' => rand(1, 10),
            ],
        ];

        collect($carts)->map(function ($cart){
            Cart::create($cart);
        });
    }
}
