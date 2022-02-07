<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $commands = [
            "php artisan server",
            "php artisan test",
            "php artisan db:seed",
            "php artisan migrate",
            "npm install",
            "npm run dev",
            "npm run production",
            "npm run build",
        ];
        $randomNumber = $this->faker->numberBetween(0, 7);
        $command = $commands[$randomNumber];

        return [
            "command" => $command,
            "description" => $this->faker->sentence(4),
        ];
    }
}
