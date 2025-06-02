<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1,20) as $product) {
            Product::create(
                [
                    'name' => 'Example Product ' . $product,
                    'slug' => 'example-product-' . $product,
                    'description' => 'This is the description for product ' . $product . '.',
                    'price' => rand(10, 100) + rand(0, 99) / 100,
                    'stock' => rand(0, 200),
                    'is_active' => rand(0, 1) ? true : false,
                    'published_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }
}
