<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Fee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Card::factory(10)->create();
        Fee::factory(10)->create();
    }
}
