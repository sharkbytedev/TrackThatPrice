<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        echo 'Generating users\n';
        User::factory()->count(50)->create();

        $this->call([
            ProductSeeder::class,
        ]);

        $users = User::all();
        $product_ids = Product::pluck('id')->all();

        foreach ($users as $user) {
            $indexes = array_rand($product_ids, 10);
            $ids = [];
            foreach ($indexes as $i) {
                array_push($ids, $product_ids[$i]);
            }
            $user->products()->attach($ids);
        }
    }
}
