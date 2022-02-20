<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MainUserSeeder;
use Database\Seeders\CollectionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call([CollectionSeeder::class]);
        $this->call([MainUserSeeder::class]);
    }
}
