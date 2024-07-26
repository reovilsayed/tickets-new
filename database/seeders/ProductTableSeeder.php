<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagePaths = [
            'products/1.png',
            'products/2.png',
            'products/3.png',
            'products/4.png',
            'products/5.png',
            'products/1.png',
            'products/2.png',
            'products/3.png',
            'products/4.png',
            'products/5.png',
            'products/1.png',
            'products/2.png',
            'products/3.png',
            'products/4.png',
            'products/5.png',
            'products/1.png',
            'products/2.png',
            'products/3.png',
            'products/4.png',
            'products/5.png',
            'products/1.png',
            'products/2.png',
            'products/3.png',
            'products/4.png',
            'products/5.png',
            'products/1.png',
            'products/2.png',
            'products/3.png',
            'products/4.png',
            'products/5.png',
            'products/5.png',


        ];
        $data = [];
        $images = [
            'products/2.png',
            'products/3.png',
            'products/4.png',
            'products/5.png',
        ];

        foreach ($imagePaths as $imagePath) {
            $data[] = [
                'shop_id' => rand(1, 5),
                'name' => fake()->name(),
                'slug' => fake()->unique()->slug(),
                'type' => fake()->word(5),
                'featured' => false,
                'description' => fake()->text(),
                'short_description' => fake()->text(),
                'sku' => fake()->word(1),
                'price' => rand(100, 1000),
                'sale_price' => rand(100, 1000),
                'total_sale' => rand(10, 100),
                'downloads' => fake()->text(),
                'manage_stock' => false,
                'quantity' => rand(10, 100),
                'rating_count' => rand(1, 5),
                'image' => $imagePath,
                'images' => json_encode($images),
                'status' => true,
            ];
        }
        DB::table('products')->insert($data);
    }
}
