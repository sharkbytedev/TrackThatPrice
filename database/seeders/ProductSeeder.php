<?php

namespace Database\Seeders;

use App\Models\HistoricalData;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->count(100)
            ->has(
                HistoricalData::factory()
                    ->count(10)
                    ->state(function (array $attributes, Product $product) {
                        return ['price' => rand($product->price-1000, $product->price+1000)];
                    })
            , 'history')
            ->create();
    }
}
