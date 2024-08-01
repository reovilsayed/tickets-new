<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\Product;
use App\Models\User;
use Database\Factories\ShopFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
        //     ShopTableSeeder::class,
        //     ProductTableSeeder::class,
        //     OrdersTableSeeder::class,
        //     AddressTableSeeder::class,
        //     ProdcatTableSeeder::class,

        // ]);
        Product::query()->delete();
        Event::query()->delete();

        Event::factory(20)->hasProducts(rand(3, 20), function (array $attributes, Event $event) {
            $start = rand(0, count($event->dates()) - 1);
            return ['start_date' => Carbon::parse($event->dates()[$start]), 'end_date' => Carbon::parse($event->dates()[rand($start, count($event->dates()) - 1)])];
        })->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Shop::factory(10)->admin()->create();
    }
}
