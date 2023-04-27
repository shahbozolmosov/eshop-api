<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory(10)->hasImages(6)->has(Stock::factory(1))->create();
    }
}
