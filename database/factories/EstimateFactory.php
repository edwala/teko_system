<?php

namespace Database\Factories;

use App\Models\Estimate;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstimateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estimate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sum' => $this->faker->text(255),
            'name' => $this->faker->name,
            'due_date' => $this->faker->date,
            'company_id' => \App\Models\Company::factory(),
            'client_id' => \App\Models\Client::factory(),
        ];
    }
}
