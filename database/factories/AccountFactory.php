<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    public function definition()
    {
        return [
            'public_uuid' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'balance' => rand(80000, 85000000)
        ];
    }
}
