<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\Estimate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientEstimatesTest extends TestCase
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
    public function it_gets_client_estimates()
    {
        $client = Client::factory()->create();
        $estimates = Estimate::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(
            route('api.clients.estimates.index', $client)
        );

        $response->assertOk()->assertSee($estimates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_client_estimates()
    {
        $client = Client::factory()->create();
        $data = Estimate::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.estimates.store', $client),
            $data
        );

        $this->assertDatabaseHas('estimates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $estimate = Estimate::latest('id')->first();

        $this->assertEquals($client->id, $estimate->client_id);
    }
}
