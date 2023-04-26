<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Man Fashion',
        ]);

        Category::create([
            'name' => 'Woman Fashion',
        ]);

        /* FOR MAN SEEDER */
        $category = Category::create([
            'name' => 'Man Shirt',
            'parent_id' => 1
        ]);

        $category = Category::create([
            'name' => 'Man Work Equipment',
            'parent_id' => 1
        ]);

        $category = Category::create([
            'name' => 'Man Shoes',
            'parent_id' => 1
        ]);

        /* FOR WOMAN SEEDER */
        $category = Category::create([
            'name' => 'Dress',
            'parent_id' => 2
        ]);


        $category = Category::create([
            'name' => 'Woman Bag',
            'parent_id' => 2
        ]);

        $category = Category::create([
            'name' => 'High Heels',
            'parent_id' => 2
        ]);
    }
}
