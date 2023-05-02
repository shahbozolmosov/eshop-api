<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::all()->random(),
            'name' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10000, 1000000000),
            'description' => fake()->paragraph(15)
        ];
    }
}
