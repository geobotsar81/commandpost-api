<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Command;
use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create 5 users with 10 collections each
        User::factory(5)
            ->has(Collection::factory(5)->has(Command::factory()->count(5)))
            ->create();
    }
}
