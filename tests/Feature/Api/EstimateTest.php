<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Estimate;

use App\Models\Client;
use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EstimateTest extends TestCase
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
    public function it_gets_estimates_list()
    {
        $estimates = Estimate::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.estimates.index'));

        $response->assertOk()->assertSee($estimates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_estimate()
    {
        $data = Estimate::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.estimates.store'), $data);

        $this->assertDatabaseHas('estimates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_estimate()
    {
        $estimate = Estimate::factory()->create();

        $company = Company::factory()->create();
        $client = Client::factory()->create();

        $data = [
            'sum' => $this->faker->text(255),
            'name' => $this->faker->name,
            'due_date' => $this->faker->date,
            'company_id' => $company->id,
            'client_id' => $client->id,
        ];

        $response = $this->putJson(
            route('api.estimates.update', $estimate),
            $data
        );

        $data['id'] = $estimate->id;

        $this->assertDatabaseHas('estimates', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_estimate()
    {
        $estimate = Estimate::factory()->create();

        $response = $this->deleteJson(
            route('api.estimates.destroy', $estimate)
        );

        $this->assertSoftDeleted($estimate);

        $response->assertNoContent();
    }
}
