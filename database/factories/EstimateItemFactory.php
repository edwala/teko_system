<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EstimateItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstimateItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EstimateItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'item_cost' => $this->faker->randomNumber(1),
            'count' => 0,
            'total_cost' => $this->faker->randomNumber(1),
            'vat' => $this->faker->randomNumber(1),
            'estimate_id' => \App\Models\Estimate::factory(),
        ];
    }
}
