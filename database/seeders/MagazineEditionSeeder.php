<?php

namespace Database\Seeders;

use App\Models\Magazine;
use App\Models\MagazineEdition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MagazineEditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = collect();

        $magazines = Magazine::all();

        $magazines->each(function (Magazine $magazine) use (&$data) {
            $editions = MagazineEdition::factory()
                ->count(5)
                ->state(['magazine_id' => $magazine->id])
                ->raw();

            $data->push($editions);
        });

        MagazineEdition::insert($data->flatten(1)->toArray());
    }
}
