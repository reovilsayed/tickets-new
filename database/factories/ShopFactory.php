<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
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
            'post_code' => fake()->postcode(),
            'country' => fake()->country(),
            'status' => true,
        ];
    }


}