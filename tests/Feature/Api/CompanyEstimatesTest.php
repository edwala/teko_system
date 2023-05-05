<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Estimate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyEstimatesTest extends TestCase
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
    public function it_gets_company_estimates()
    {
        $company = Company::factory()->create();
        $estimates = Estimate::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.estimates.index', $company)
        );

        $response->assertOk()->assertSee($estimates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_estimates()
    {
        $company = Company::factory()->create();
        $data = Estimate::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.estimates.store', $company),
            $data
        );

        $this->assertDatabaseHas('estimates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $estimate = Estimate::latest('id')->first();

        $this->assertEquals($company->id, $estimate->company_id);
    }
}
