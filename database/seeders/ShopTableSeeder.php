<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagePaths = [
            'shop/shop1.png',
            'shop/shop2.png',
            'shop/shop3.png',
            'shop/shop4.png',
            'shop/shop3.png',
            
      
       
        ];
        $data = [];
        // Shop::factory()->count(5)->create();
        foreach ($imagePaths as $imagePath) {
            $data[] = [
            'user_id'=>rand(1,5),
            'name' => fake()->name(),
            'slug' => fake()->unique()->username(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->paragraphs(3,true),
            'short_description' => fake()->paragraphs(1,true),
            'tags' => json_encode(fake()->words(3)),
            'terms' => fake()->text(),
            'company_name' => fake()->userName(),
            'company_registration' => fake()->uuid(),
            'state' => fake()->state(),
            'city' => fake()->city(),
            'logo' =>$imagePath,
            'post_code' => fake()->postcode(),
            'country' => fake()->country(),
            'status' => true,
        ];
    }
    DB::table('shops')->insert($data);
}
}