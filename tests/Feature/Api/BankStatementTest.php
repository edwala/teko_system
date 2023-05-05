<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BankStatement;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankStatementTest extends TestCase
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
    public function it_gets_bank_statements_list()
    {
        $bankStatements = BankStatement::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.bank-statements.index'));

        $response->assertOk()->assertSee($bankStatements[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_bank_statement()
    {
        $data = BankStatement::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.bank-statements.store'), $data);

        $this->assertDatabaseHas('bank_statements', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_bank_statement()
    {
        $bankStatement = BankStatement::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'file' => $this->faker->text(255),
            'company_id' => $company->id,
        ];

        $response = $this->putJson(
            route('api.bank-statements.update', $bankStatement),
            $data
        );

        $data['id'] = $bankStatement->id;

        $this->assertDatabaseHas('bank_statements', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_bank_statement()
    {
        $bankStatement = BankStatement::factory()->create();

        $response = $this->deleteJson(
            route('api.bank-statements.destroy', $bankStatement)
        );

        $this->assertSoftDeleted($bankStatement);

        $response->assertNoContent();
    }
}
