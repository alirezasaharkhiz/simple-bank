<?php

namespace Database\Factories;

use App\Constants\Constants;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    public function definition()
    {
        return [
            'from_card_id' => User::factory(),
            'to_card_id' => User::factory(),
            'amount' => rand(200000,3000000),
            'follow_up_id' => Str::random(Constants::FOLLOW_UP_ID_LENGTH)
        ];
    }
}
