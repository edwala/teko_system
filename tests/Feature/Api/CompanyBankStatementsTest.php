<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\BankStatement;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyBankStatementsTest extends TestCase
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
    public function it_gets_company_bank_statements()
    {
        $company = Company::factory()->create();
        $bankStatements = BankStatement::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.bank-statements.index', $company)
        );

        $response->assertOk()->assertSee($bankStatements[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_company_bank_statements()
    {
        $company = Company::factory()->create();
        $data = BankStatement::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.bank-statements.store', $company),
            $data
        );

        $this->assertDatabaseHas('bank_statements', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $bankStatement = BankStatement::latest('id')->first();

        $this->assertEquals($company->id, $bankStatement->company_id);
    }
}
