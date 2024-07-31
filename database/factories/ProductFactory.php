<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $ticketNames = [
            'Early Bird',
            'Standard Admission',
            'VIP Pass',
            'Student Ticket',
            'Group Package',
            'Day Pass',
            'Workshop Access',
            'Exhibition Only',
            'Speaker Pass',
            'Sponsor Ticket',
        ];

        return [
            'name' => fake()->randomElement($ticketNames),
            'description' => fake()->sentence(),
            'price' => 20,
            'sale_price' => rand(0, 1) ? rand(8, 15) : null,
            'sold_out' => rand(0, 1),
            'quantity' => rand(300, 1000),
        ];
    }
}
