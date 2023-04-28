<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            ["name" => "Andijon viloyati"],
            ["name" => "Buxoro viloyati"],
            ["name" => "Fargʻona viloyati"],
            ["name" => "Jizzax viloyati"],
            ["name" => "Xorazm viloyati"],
            ["name" => "Namangan viloyati"],
            ["name" => "Navoiy viloyati"],
            ["name" => "Qashqadaryo viloyati"],
            ["name" => "Samarqand viloyati"],
            ["name" => "Sirdaryo viloyati"],
            ["name" => "Surxondaryo viloyati"],
            ["name" => "Toshkent viloyati"],
            ["name" => "Qoraqalpogʻiston Respublikasi"],
        ];

        collect($regions)->map(function ($region){
           Region::create($region);
        });
    }
}
