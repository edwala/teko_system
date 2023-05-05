<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->text(255),
            'billing_address' => $this->faker->text(255),
            'tax_id' => $this->faker->text(255),
            'vat_id' => $this->faker->text(255),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
