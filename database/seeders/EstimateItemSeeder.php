<?php

namespace Database\Seeders;

use App\Models\EstimateItem;
use Illuminate\Database\Seeder;

class EstimateItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstimateItem::factory()
            ->count(5)
            ->create();
    }
}
