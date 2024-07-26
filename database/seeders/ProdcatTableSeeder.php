<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdcatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagePaths = [
            'cat/1.png',
            'cat/2.png',
            'cat/3.png',
            'cat/4.png',
            'cat/5.png',
            'cat/1.png',
            'cat/2.png',
            'cat/3.png',
            'cat/4.png',
            'cat/5.png',
            'cat/1.png',
            'cat/2.png',
            'cat/3.png',
            'cat/4.png',
            'cat/5.png',




        ];
        $data = [];

        foreach ($imagePaths as $imagePath) {
            $data[] = [
                'shop_id' => rand(1, 15),
                'name' => fake()->name(),
                'slug' => fake()->unique()->username(),
                'shop_id' => rand(1, 5),
                'logo' => $imagePath,

            ];
        }
        DB::table('prodcats')->insert($data);
    }
}
