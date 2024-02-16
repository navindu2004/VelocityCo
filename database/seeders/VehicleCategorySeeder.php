<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'vehicle_category_name' => 'Sedan',
                'brand' => 'Toyota',
                'model' => 'Vios',
                'year' => '2019',
                'color' => 'Black',
                'plate_number' => 'ABC123',
                'price' => 'LKR 1000000',
            ],
            
            
        ];

        foreach ($categories as $description) {
            \App\Models\VehicleCategory::create([
                'vehicle_category_name' => $description['vehicle_category_name'],
                'brand' => $description['brand'],
                'model' => $description['model'],
                'year' => $description['year'],
                'color' => $description['color'],
                'plate_number' => $description['plate_number'],
                'price' => $description['price'],
            ]);
        }
    }


}
