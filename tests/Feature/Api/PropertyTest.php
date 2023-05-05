<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Property;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTest extends TestCase
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
    public function it_gets_properties_list()
    {
        $properties = Property::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.properties.index'));

        $response->assertOk()->assertSee($properties[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_property()
    {
        $data = Property::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.properties.store'), $data);

        $this->assertDatabaseHas('properties', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_property()
    {
        $property = Property::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'company_id' => $company->id,
        ];

        $response = $this->putJson(
            route('api.properties.update', $property),
            $data
        );

        $data['id'] = $property->id;

        $this->assertDatabaseHas('properties', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_property()
    {
        $property = Property::factory()->create();

        $response = $this->deleteJson(
            route('api.properties.destroy', $property)
        );

        $this->assertSoftDeleted($property);

        $response->assertNoContent();
    }
}
