<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1000, 50000),
            'category' => fake()->randomElement(['makanan', 'minuman', 'snack']),
            'image' => null,
            'daily_quota' => fake()->numberBetween(5, 50),
            'is_available' => true,
        ];
    }
}
