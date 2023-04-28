<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            [
                'region_id' => 9,
                'name' => "Urgut tumani",
            ],
            [
                'region_id' => 9,
                'name' => "Tayloq tumani",
            ],
            [
                'region_id' => 9,
                'name' => "Samarqand shahri",
            ],
            [
                'region_id' => 9,
                'name' => "Bulung'ur tumani",
            ],
        ];

        collect($districts)->map(function ($district){
            District::create($district);
        });
    }
}
