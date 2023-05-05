<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ExpenseCategory;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryTest extends TestCase
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
    public function it_gets_expense_categories_list()
    {
        $expenseCategories = ExpenseCategory::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.expense-categories.index'));

        $response->assertOk()->assertSee($expenseCategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_expense_category()
    {
        $data = ExpenseCategory::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.expense-categories.store'),
            $data
        );

        $this->assertDatabaseHas('expense_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'company_id' => $company->id,
        ];

        $response = $this->putJson(
            route('api.expense-categories.update', $expenseCategory),
            $data
        );

        $data['id'] = $expenseCategory->id;

        $this->assertDatabaseHas('expense_categories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $response = $this->deleteJson(
            route('api.expense-categories.destroy', $expenseCategory)
        );

        $this->assertSoftDeleted($expenseCategory);

        $response->assertNoContent();
    }
}
