<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => $this->faker->text(255),
            'suplier' => $this->faker->text(255),
            'company_id' => \App\Models\Company::factory(),
            'expense_category_id' => \App\Models\ExpenseCategory::factory(),
            'property_id' => \App\Models\Property::factory(),
            'service_id' => \App\Models\Service::factory(),
        ];
    }
}
