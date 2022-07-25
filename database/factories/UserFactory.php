<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'mobile' => $this->faker->unique()->phoneNumber(),
        ];
    }
}
