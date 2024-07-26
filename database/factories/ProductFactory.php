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
        $event_name = [
            "Coachella",
            "SXSW",
            "Glastonbury Festival",
            "Lollapalooza",
            "Burning Man",
            "Tomorrowland",
            "TED Conference",
            "Google I/O",
            "Apple WWDC",
            "TechCrunch Disrupt",
            "Microsoft Build",
            "DreamHack",
            "DEF CON",
            "HackMIT",
            "Music Midtown",
            "Summerfest",
            "Cannes Film Festival",
            "Comic-Con International",
            "New York Fashion Week",
            "Venice Biennale"
        ];

        $name = fake()->randomElement($event_name);

        return [

            'name' => $name . ' Ticket',
            'slug' => Str::slug($name . ' ' . uniqid()),
            'featured' => true,
            'event_name' => $name,
            'event_host' => fake()->company(),
            'event_start_date' => now()->addDays(10),
            'event_end_date' => now()->addDays(12),
            'last_date_of_purchase' => now()->addDays(8),
            'event_location' => fake()->city(),
            'short_description' => fake()->paragraphs(3, true),
            'description' => fake()->paragraphs(3, true),
            'price' => 120,
            'sale_price' => 100,
            'quantity' => 100,
            'image' => ['product/one.jpg', 'product/two.jpg', 'product/three.jpg', 'product/four.jpg'][rand(0, 3)],

        ];

    }
}
