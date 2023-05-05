<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Template;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTemplatesTest extends TestCase
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
    public function it_gets_company_templates()
    {
        $company = Company::factory()->create();
        $templates = Template::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.templates.index', $company)
        );

        $response->assertOk()->assertSee($templates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_templates()
    {
        $company = Company::factory()->create();
        $data = Template::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.templates.store', $company),
            $data
        );

        $this->assertDatabaseHas('templates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $template = Template::latest('id')->first();

        $this->assertEquals($company->id, $template->company_id);
    }
}
