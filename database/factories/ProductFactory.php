<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'product_name' => fake()->text(50),
            'product_url' => fake()->url(),
            'update_interval' => 24,
            'store' => array_rand(['amazon', 'ebay']),
            'upc' => fake()->ean13(),
            'price' => rand(1000, 10000),
            'currency' => fake()->currencyCode(),
            'valid' => 1
        ];
    }
}
