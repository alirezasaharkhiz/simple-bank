<?php

namespace Database\Factories;

use App\Externals\helpers\Helper;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    public function definition()
    {
        return [
            'public_number' => Helper::generateCardNumber(),
            'account_id' => Account::factory(),
        ];
    }
}
