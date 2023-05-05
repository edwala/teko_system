<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'content' => $this->faker->text,
            'revision' => $this->faker->date,
            'category' => $this->faker->text(255),
            'company_id' => \App\Models\Company::factory(),
            'client_id' => \App\Models\Client::factory(),
            'employee_id' => \App\Models\Employee::factory(),
        ];
    }
}
