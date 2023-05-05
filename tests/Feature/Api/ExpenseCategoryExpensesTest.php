<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Expense;
use App\Models\ExpenseCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryExpensesTest extends TestCase
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
    public function it_gets_expense_category_expenses()
    {
        $expenseCategory = ExpenseCategory::factory()->create();
        $expenses = Expense::factory()
            ->count(2)
            ->create([
                'expense_category_id' => $expenseCategory->id,
            ]);

        $response = $this->getJson(
            route('api.expense-categories.expenses.index', $expenseCategory)
        );

        $response->assertOk()->assertSee($expenses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_expense_category_expenses()
    {
        $expenseCategory = ExpenseCategory::factory()->create();
        $data = Expense::factory()
            ->make([
                'expense_category_id' => $expenseCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.expense-categories.expenses.store', $expenseCategory),
            $data
        );

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expense = Expense::latest('id')->first();

        $this->assertEquals(
            $expenseCategory->id,
            $expense->expense_category_id
        );
    }
}
