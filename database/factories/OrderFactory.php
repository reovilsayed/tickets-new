<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()

    {
        $billing = [
            'first_name' => fake()->firstName(),
            'last_name' =>  fake()->lastName(),
            'email' =>  fake()->email(),
            'address_1' =>  fake()->address(),
            'address_2' =>  fake()->address(),
            'city' =>  fake()->city(),
            'post_code' =>  fake()->postcode(),
            'state' =>  fake()->state(),
            'phone' =>  fake()->phoneNumber(),
        ];
        // $shipping = [
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'email' => $request->email,
        //     'address_1' => $request->address_1,
        //     'address_2' => $request->address_2,
        //     'city' => $request->city,
        //     'post_code' => $request->post_code,
        //     'state' => $request->state,
        //     'phone' => $request->phone,
        //     'shipping_method' => null,
        //     'shipping_url' => null,
        // ];
        $shipping = $billing;
        $shipping['shipping_method'] = 'hello';
        $shipping['shipping_url'] = 'hello';

        return [
            'user_id' => rand(1, 5),
            'product_id' => rand(1, 10),
            'currency' => fake()->currencyCode(),
            'discount' => rand(10, 20),
            'discount_code' => rand(10, 20),
            'shipping_total' => rand(10, 50),

            'shipping' => json_encode($shipping),
            'billing' => json_encode($billing),
            'subtotal' => rand(100, 500),
            'total' => rand(100, 500),
            'tax' => rand(10, 20),
            'customer_note' => fake()->text(),
            'payment_method' => fake()->creditCardType(),
            'payment_method_title' => fake()->creditCardType(),
            'transaction_id' => fake()->swiftBicNumber(),
            'quantity' => rand(10, 20),
            'aptment' => fake()->city(),

        ];
    }
}
