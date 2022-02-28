<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Command;
use App\Models\Collection;
use Illuminate\Database\Seeder;

class MainUserSeeder extends Seeder
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
            "theme" => 2,
        ]);

        $collections = ["PHP", "Git", "NPM", "Linux", "Laravel", "VueJS"];

        $commands["Laravel"] = ["php artisan db:wipe && php artisan migrate && php artisan db:seed", "php artisan serve", "php artisan test", "php artisan db:seed", "php artisan migrate"];
        $commands["NPM"] = ["npm install", "npm run dev", "npm run production", "npm run build"];
        $commands["Linux"] = ["ls", "cat", "touch"];
        $commands["Git"] = ["git init", "git remote update", "git remote add origin"];

        foreach ($collections as $collection) {
            $newCollection = Collection::create([
                "title" => $collection,
                "user_id" => $user->id,
            ]);

            if (!empty($commands[$collection])) {
                foreach ($commands[$collection] as $command) {
                    $newCommand = Command::create([
                        "command" => $command,
                        "collection_id" => $newCollection->id,
                    ]);
                }
            }
        }
    }
}
