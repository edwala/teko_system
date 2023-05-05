<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'content' => $this->faker->text,
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
