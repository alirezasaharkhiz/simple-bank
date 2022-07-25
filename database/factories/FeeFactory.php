<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeeFactory extends Factory
{
    public function definition()
    {
        return [
            'transaction_id' => Transaction::factory(),
            'amount' => 500
        ];
    }
}
