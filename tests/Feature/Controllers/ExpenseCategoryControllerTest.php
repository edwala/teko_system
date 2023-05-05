<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ExpenseCategory;

use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryControllerTest extends TestCase
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
    public function it_displays_index_view_with_expense_categories()
    {
        $expenseCategories = ExpenseCategory::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('expense-categories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.expense_categories.index')
            ->assertViewHas('expenseCategories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_expense_category()
    {
        $response = $this->get(route('expense-categories.create'));

        $response->assertOk()->assertViewIs('app.expense_categories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_expense_category()
    {
        $data = ExpenseCategory::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('expense-categories.store'), $data);

        $this->assertDatabaseHas('expense_categories', $data);

        $expenseCategory = ExpenseCategory::latest('id')->first();

        $response->assertRedirect(
            route('expense-categories.edit', $expenseCategory)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $response = $this->get(
            route('expense-categories.show', $expenseCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.expense_categories.show')
            ->assertViewHas('expenseCategory');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $response = $this->get(
            route('expense-categories.edit', $expenseCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.expense_categories.edit')
            ->assertViewHas('expenseCategory');
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

        $response = $this->put(
            route('expense-categories.update', $expenseCategory),
            $data
        );

        $data['id'] = $expenseCategory->id;

        $this->assertDatabaseHas('expense_categories', $data);

        $response->assertRedirect(
            route('expense-categories.edit', $expenseCategory)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $response = $this->delete(
            route('expense-categories.destroy', $expenseCategory)
        );

        $response->assertRedirect(route('expense-categories.index'));

        $this->assertSoftDeleted($expenseCategory);
    }
}
