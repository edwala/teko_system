<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\BankStatement;

use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankStatementControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_bank_statements()
    {
        $bankStatements = BankStatement::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('bank-statements.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.bank_statements.index')
            ->assertViewHas('bankStatements');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_bank_statement()
    {
        $response = $this->get(route('bank-statements.create'));

        $response->assertOk()->assertViewIs('app.bank_statements.create');
    }

    /**
     * @test
     */
    public function it_stores_the_bank_statement()
    {
        $data = BankStatement::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('bank-statements.store'), $data);

        $this->assertDatabaseHas('bank_statements', $data);

        $bankStatement = BankStatement::latest('id')->first();

        $response->assertRedirect(
            route('bank-statements.edit', $bankStatement)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_bank_statement()
    {
        $bankStatement = BankStatement::factory()->create();

        $response = $this->get(route('bank-statements.show', $bankStatement));

        $response
            ->assertOk()
            ->assertViewIs('app.bank_statements.show')
            ->assertViewHas('bankStatement');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_bank_statement()
    {
        $bankStatement = BankStatement::factory()->create();

        $response = $this->get(route('bank-statements.edit', $bankStatement));

        $response
            ->assertOk()
            ->assertViewIs('app.bank_statements.edit')
            ->assertViewHas('bankStatement');
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

        $response = $this->put(
            route('bank-statements.update', $bankStatement),
            $data
        );

        $data['id'] = $bankStatement->id;

        $this->assertDatabaseHas('bank_statements', $data);

        $response->assertRedirect(
            route('bank-statements.edit', $bankStatement)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_bank_statement()
    {
        $bankStatement = BankStatement::factory()->create();

        $response = $this->delete(
            route('bank-statements.destroy', $bankStatement)
        );

        $response->assertRedirect(route('bank-statements.index'));

        $this->assertSoftDeleted($bankStatement);
    }
}
