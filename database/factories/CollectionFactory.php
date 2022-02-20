<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $collections = ["PHP", "Javascript", "NPM", "Linux", "Laravel", "VueJS"];
        $randomNumber = $this->faker->numberBetween(0, 5);
        $title = $collections[$randomNumber];

        return [
            "title" => $title,
            "user_id" => 1,
        ];
    }
}
