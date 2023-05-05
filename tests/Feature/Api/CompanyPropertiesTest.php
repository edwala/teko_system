<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Property;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyPropertiesTest extends TestCase
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
    public function it_gets_company_properties()
    {
        $company = Company::factory()->create();
        $properties = Property::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.properties.index', $company)
        );

        $response->assertOk()->assertSee($properties[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_properties()
    {
        $company = Company::factory()->create();
        $data = Property::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.properties.store', $company),
            $data
        );

        $this->assertDatabaseHas('properties', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $property = Property::latest('id')->first();

        $this->assertEquals($company->id, $property->company_id);
    }
}
