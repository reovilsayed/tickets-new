<?php

namespace Database\Seeders;

use App\Models\Magazine;
use Illuminate\Database\Seeder;

class MagazineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Magazine::factory()->count(50)->create();
    }
}
