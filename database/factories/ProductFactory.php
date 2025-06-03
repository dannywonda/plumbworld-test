<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->words(3, true),
            'slug'          => Str::slug($this->faker->words(3, true)),
            'description'   => $this->faker->sentence(),
            'price'         => $this->faker->randomFloat(2, 10, 1000), // e.g. 10.00 to 1000.00
            'stock'         => $this->faker->numberBetween(0, 100),
            'is_active'     => $this->faker->boolean(80), // 80% chance active
            'published_at'  => now(),
        ];
    }
}
