<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\ExpenseCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyExpenseCategoriesTest extends TestCase
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
    public function it_gets_company_expense_categories()
    {
        $company = Company::factory()->create();
        $expenseCategories = ExpenseCategory::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.expense-categories.index', $company)
        );

        $response->assertOk()->assertSee($expenseCategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_expense_categories()
    {
        $company = Company::factory()->create();
        $data = ExpenseCategory::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.expense-categories.store', $company),
            $data
        );

        $this->assertDatabaseHas('expense_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expenseCategory = ExpenseCategory::latest('id')->first();

        $this->assertEquals($company->id, $expenseCategory->company_id);
    }
}
