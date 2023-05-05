<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\BankStatement;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankStatementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankStatement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'month' => rand(1, 12),
            'file' => $this->faker->text(255),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
