<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Service;
use App\Models\Expense;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceExpensesTest extends TestCase
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
    public function it_gets_service_expenses()
    {
        $service = Service::factory()->create();
        $expenses = Expense::factory()
            ->count(2)
            ->create([
                'service_id' => $service->id,
            ]);

        $response = $this->getJson(
            route('api.services.expenses.index', $service)
        );

        $response->assertOk()->assertSee($expenses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_service_expenses()
    {
        $service = Service::factory()->create();
        $data = Expense::factory()
            ->make([
                'service_id' => $service->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.services.expenses.store', $service),
            $data
        );

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expense = Expense::latest('id')->first();

        $this->assertEquals($service->id, $expense->service_id);
    }
}
