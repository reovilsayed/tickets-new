<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $event_name = [
            'Coachella',
            'SXSW',
            'Glastonbury Festival',
            'Lollapalooza',
            'Burning Man',
            'Tomorrowland',
            'TED Conference',
            'Google I/O',
            'Apple WWDC',
            'TechCrunch Disrupt',
            'Microsoft Build',
            'DreamHack',
            'DEF CON',
            'HackMIT',
            'Music Midtown',
            'Summerfest',
            'Cannes Film Festival',
            'Comic-Con International',
            'New York Fashion Week',
            'Venice Biennale'
        ];

        $country = fake()->country();
        $city = fake()->city();
        $name = fake()->randomElement($event_name) . ' ' . $city;
        $date = now()->addDays(rand(20, 80));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'organizer' => fake()->company(),
            'start_at' => (clone $date),
            'end_at' => (clone $date->addDays(rand(0, 5))),
            'country' => $country,
            'city' => $city,
            'description' => fake()->sentence(),
            'location' => fake()->address(),
            'featured' => rand(0, 1),
            'status' => true,
            'thumbnail' => ['product/one.jpg', 'product/two.jpg', 'product/three.jpg', 'product/four.jpg'][rand(0, 3)]
        ];
    }
}
