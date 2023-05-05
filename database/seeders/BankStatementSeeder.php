<?php

namespace Database\Seeders;

use App\Models\BankStatement;
use Illuminate\Database\Seeder;

class BankStatementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankStatement::factory()
            ->count(5)
            ->create();
    }
}
