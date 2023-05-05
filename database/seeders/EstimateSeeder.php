<?php

namespace Database\Seeders;

use App\Models\Estimate;
use Illuminate\Database\Seeder;

class EstimateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estimate::factory()
            ->count(5)
            ->create();
    }
}
