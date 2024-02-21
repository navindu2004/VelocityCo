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
                'name' => 'Car',
                'description' => 'A car is a wheeled motor vehicle used for transportation.',
                'status' => 1,
            ],
            [
                'name' => 'Motorcycle',
                'description' => 'A motorcycle, often called a motorbike, bike, or cycle, is a two- or three-wheeled motor vehicle.',
                'status' => 1,
            ],
            [
                'name' => 'Truck',
                'description' => 'A truck or lorry is a motor vehicle designed to transport cargo.',
                'status' => 1,
            ],
            [
                'name' => 'Bus',
                'description' => 'A bus is a road vehicle designed to carry many passengers.',
                'status' => 1,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\VehicleCategory::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'status' => $category['status'],
            ]);
        }
    }
}
