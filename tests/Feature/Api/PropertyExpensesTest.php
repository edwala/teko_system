<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Expense;
use App\Models\Property;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyExpensesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_property_expenses()
    {
        $property = Property::factory()->create();
        $expenses = Expense::factory()
            ->count(2)
            ->create([
                'property_id' => $property->id,
            ]);

        $response = $this->getJson(
            route('api.properties.expenses.index', $property)
        );

        $response->assertOk()->assertSee($expenses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_property_expenses()
    {
        $property = Property::factory()->create();
        $data = Expense::factory()
            ->make([
                'property_id' => $property->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.properties.expenses.store', $property),
            $data
        );

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expense = Expense::latest('id')->first();

        $this->assertEquals($property->id, $expense->property_id);
    }
}
