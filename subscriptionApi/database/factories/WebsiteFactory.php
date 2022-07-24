<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $domain = $this->faker->unique()->domainName;
        return [
            'name' => $domain,
            'url' => $domain,
        ];
    }
}
