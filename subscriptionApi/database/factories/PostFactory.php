<?php

namespace Database\Factories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'website_id' => Website::inRandomOrder()->first(),
            'title' => $this->faker->realText,
            'description' => $this->faker->text,
        ];
    }
}
