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
            'end_at' => (clone $date->addDays(rand(0,5))),
            'country' => $country,
            'city' => $city,
            'description' => "<div class='event-description'>
    <h2>Annual Tech Conference 2024</h2>
    <p>Join us for the Annual Tech Conference 2024, a premier event for professionals in the tech industry. This year's conference will be held from <strong>August 15th to August 18th</strong> at the <em>Grand Convention Center</em>.</p>
    <h3>Event Highlights:</h3>
    <ul>
        <li>Keynote speeches from industry leaders</li>
        <li>Workshops on the latest technologies and trends</li>
        <li>Networking opportunities with professionals and companies</li>
        <li>Exhibition of cutting-edge products and services</li>
    </ul>
    <h3>Speakers:</h3>
    <p>We have an exciting lineup of speakers including:</p>
    <ul>
        <li>John Doe - CEO of Tech Innovators</li>
        <li>Jane Smith - CTO of Future Tech Solutions</li>
        <li>Robert Johnson - Lead Developer at NextGen Technologies</li>
    </ul>
    <h3>Schedule:</h3>
    <p>The event will follow the schedule below:</p>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>August 15</td>
                <td>09:00 AM - 10:00 AM</td>
                <td>Opening Ceremony</td>
            </tr>
            <tr>
                <td>August 15</td>
                <td>10:00 AM - 12:00 PM</td>
                <td>Keynote Speeches</td>
            </tr>
            <tr>
                <td>August 16</td>
                <td>10:00 AM - 04:00 PM</td>
                <td>Workshops and Panels</td>
            </tr>
            <tr>
                <td>August 17</td>
                <td>10:00 AM - 04:00 PM</td>
                <td>Product Exhibitions</td>
            </tr>
            <tr>
                <td>August 18</td>
                <td>12:00 PM - 02:00 PM</td>
                <td>Closing Remarks and Networking</td>
            </tr>
        </tbody>
    </table>
    <h3>Registration:</h3>
    <p>Register now to secure your spot at this must-attend event. Early bird discounts are available until July 31st.</p>    
    <p>For more information, visit our <a href='https://www.techconference2024.com'>official website</a>.</p>
</div>",

            'location' => fake()->address(),
            'featured' => rand(0, 1),
            'status' => true,
            'thumbnail' => ['product/one.jpg', 'product/two.jpg', 'product/three.jpg', 'product/four.jpg'][rand(0, 3)]
        ];
    }
}
