<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;


class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            User::factory()->count(5)->create();

            // User::create([
            //     'name'           => 'Admin',
            //     'email'          => 'admin@admin.com',
            //     'password'       => bcrypt('password'),
            //     'remember_token' => Str::random(60),
            //     'role_id'        => rand(1,3),
            // ]);
        }
    }
}
