<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // \App\Models\User::factory(10)->create();
         Website::factory(10)->create();
         Post::factory(20)->create();
         User::factory(10)->create();

        $users = User::all();
        $websites = Website::all();
        foreach ($websites as $website) {
            foreach ($users as $user) {
                $user->websites()->syncWithoutDetaching([$website->id]);
            }
        }
    }
}
