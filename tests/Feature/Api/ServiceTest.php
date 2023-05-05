<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Service;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
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
    public function it_gets_services_list()
    {
        $services = Service::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.services.index'));

        $response->assertOk()->assertSee($services[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_service()
    {
        $data = Service::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.services.store'), $data);

        $this->assertDatabaseHas('services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_service()
    {
        $service = Service::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'company_id' => $company->id,
        ];

        $response = $this->putJson(
            route('api.services.update', $service),
            $data
        );

        $data['id'] = $service->id;

        $this->assertDatabaseHas('services', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_service()
    {
        $service = Service::factory()->create();

        $response = $this->deleteJson(route('api.services.destroy', $service));

        $this->assertSoftDeleted($service);

        $response->assertNoContent();
    }
}
