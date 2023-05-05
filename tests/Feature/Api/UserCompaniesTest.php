<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCompaniesTest extends TestCase
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
    public function it_gets_user_companies()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $user->companies()->attach($company);

        $response = $this->getJson(route('api.users.companies.index', $user));

        $response->assertOk()->assertSee($company->company_name);
    }

    /**
     * @test
     */
    public function it_can_attach_companies_to_user()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $response = $this->postJson(
            route('api.users.companies.store', [$user, $company])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->companies()
                ->where('companies.id', $company->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_companies_from_user()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $response = $this->deleteJson(
            route('api.users.companies.store', [$user, $company])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->companies()
                ->where('companies.id', $company->id)
                ->exists()
        );
    }
}
