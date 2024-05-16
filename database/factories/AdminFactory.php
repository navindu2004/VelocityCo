<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Admin',
            'email' => 'admin3@gmail.com',
            //'role' => $this->faker->numberBetween(1, 4),
            'email_verified_at' => now(),
            'password' => 'admin12345', // password
            'remember_token' => Str::random(10),
            'updated_at' => now(),
            'type' => 'admin',
        ];
    }
}
