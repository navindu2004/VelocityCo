<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'admin@admin.com')->first();

        if (!$user) {
            \App\Models\User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'role' => 1,
            ]);
        }

        $this->call([
            ProductCategorySeeder::class,
        ]);
    }
}
