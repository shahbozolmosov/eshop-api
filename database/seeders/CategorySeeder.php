<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
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

        $image = new Image(['url' => 'category-images/shirt.png']);
        $category->images()->save($image);

        $category = Category::create([
            'name' => 'Man Work Equipment',
            'parent_id' => 1
        ]);
        $image = new Image(['url' => 'category-images/man-bag.png']);
        $category->images()->save($image);

        $category = Category::create([
            'name' => 'Man Shoes',
            'parent_id' => 1
        ]);
        $image = new Image(['url' => 'category-images/man-shoes.png']);
        $category->images()->save($image);

        /* FOR WOMAN SEEDER */
        $category = Category::create([
            'name' => 'Dress',
            'parent_id' => 2
        ]);
        $image = new Image(['url' => 'category-images/fashion.png']);
        $category->images()->save($image);

        $category = Category::create([
            'name' => 'Woman Bag',
            'parent_id' => 2
        ]);
        $image = new Image(['url' => 'category-images/woman-bag.png']);
        $category->images()->save($image);

        $category = Category::create([
            'name' => 'High Heels',
            'parent_id' => 2
        ]);
        $image = new Image(['url' => 'category-images/woman-shoes.png']);
        $category->images()->save($image);
    }
}
