<?php

namespace Database\Seeders;
use App\Models\Vehicle;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        \App\Models\User::factory(10)->create();

        
            \App\Models\User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'role' => 1,
            ]);
        

            $this->call([
                VehicleSeeder::class,
                VehicleCategorySeeder::class,
            ]);

    }
}
