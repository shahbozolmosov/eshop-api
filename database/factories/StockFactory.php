<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'qty_left' => rand(1, 12),
            'attributes' => json_encode('1')
        ];
    }
}
