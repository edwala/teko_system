<?php

namespace Database\Factories;

use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'item_cost' => $this->faker->randomNumber(1),
            'count' => 0,
            'total_cost' => $this->faker->randomNumber(1),
            'vat' => $this->faker->randomNumber(1),
            'invoice_id' => \App\Models\Invoice::factory(),
        ];
    }
}
