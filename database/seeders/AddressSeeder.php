<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $address = Address::create([
            'region_id' => 9,
            'district_id' => rand(1, 4),
            'street' => fake()->sentence(),
            'house' => fake()->sentence(),
            'apartment' => rand(1, 120),
            'floor' => rand(1, 12),
        ]);

        $address->users()->attach([2]);

        $address = Address::create([
            'region_id' => 9,
            'district_id' => rand(1, 4),
            'street' => fake()->sentence(),
            'house' => fake()->sentence(),
            'apartment' => rand(1, 120),
            'floor' => rand(1, 12),
        ]);

        $address->users()->attach([2]);

        $address = Address::create([
            'region_id' => 9,
            'district_id' => rand(1, 4),
            'street' => fake()->sentence(),
            'house' => fake()->sentence(),
            'apartment' => rand(1, 120),
            'floor' => rand(1, 12),
        ]);

        $address->users()->attach([2]);

    }
}
