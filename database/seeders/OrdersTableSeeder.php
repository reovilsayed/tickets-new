<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $shops = Shop::all();


        // $shops->each(function ($shop) {
        //     $orders = Order::factory()->count(50)->make();
        //     $shop->orders()->saveMany($orders);
        // });
    }
}
