<?php

namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $favorites = [
            [
                'user_id' => 2,
                'product_id' => 1
            ],
            [
                'user_id' => 2,
                'product_id' => 2
            ],
            [
                'user_id' => 2,
                'product_id' => 3
            ],
            [
                'user_id' => 2,
                'product_id' => 4
            ],
            [
                'user_id' => 2,
                'product_id' => 5
            ],
        ];

        collect($favorites)->map(function ($favorite){
           Favorite::create($favorite);
        });
    }
}
