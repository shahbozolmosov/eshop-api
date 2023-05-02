<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'qty_left' => 10,
            'attributes' => json_encode('1')
        ];
    }
}
