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
        //Create default user
        $user = User::factory()->create([
            "name" => "George Botsaris",
            "email" => "geobotsar@hotmail.com",
            "email_verified_at" => date("Y-m-d H:i:s", time()),
            "created_at" => date("Y-m-d H:i:s", time()),
            "updated_at" => date("Y-m-d H:i:s", time()),
            "password" => bcrypt("commandpost1981"),
        ]);

        //Create 5 users with 10 collections each
        User::factory(5)
            ->has(Collection::factory(5)->has(Command::factory()->count(5)))
            ->create();
    }
}
