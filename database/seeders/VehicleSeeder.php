<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'category_id' => 1,  // Use the correct category_id value
                'name' => 'Toyota',
                'model' => 'Corolla',
                'year' => '2019',
                'color' => 'White',
                'license_plate' => 'ABC-123',
                'chassis_number' => '123456789',
                'engine_number' => '987654321',
                'purchase_date' => '2021-01-01',
                'purchase_price' => '1000000',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($vehicles as $vehicle) {
            \App\Models\Vehicle::create($vehicle);
        }

    }
}
