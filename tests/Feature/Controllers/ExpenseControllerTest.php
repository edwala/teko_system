<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Expense;

use App\Models\Company;
use App\Models\Service;
use App\Models\Property;
use App\Models\ExpenseCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseControllerTest extends TestCase
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
    public function it_displays_index_view_with_expenses()
    {
        $expenses = Expense::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('expenses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.expenses.index')
            ->assertViewHas('expenses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_expense()
    {
        $response = $this->get(route('expenses.create'));

        $response->assertOk()->assertViewIs('app.expenses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_expense()
    {
        $data = Expense::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('expenses.store'), $data);

        $this->assertDatabaseHas('expenses', $data);

        $expense = Expense::latest('id')->first();

        $response->assertRedirect(route('expenses.edit', $expense));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->get(route('expenses.show', $expense));

        $response
            ->assertOk()
            ->assertViewIs('app.expenses.show')
            ->assertViewHas('expense');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->get(route('expenses.edit', $expense));

        $response
            ->assertOk()
            ->assertViewIs('app.expenses.edit')
            ->assertViewHas('expense');
    }

    /**
     * @test
     */
    public function it_updates_the_expense()
    {
        $expense = Expense::factory()->create();

        $company = Company::factory()->create();
        $expenseCategory = ExpenseCategory::factory()->create();
        $property = Property::factory()->create();
        $service = Service::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'type' => $this->faker->text(255),
            'suplier' => $this->faker->text(255),
            'company_id' => $company->id,
            'expense_category_id' => $expenseCategory->id,
            'property_id' => $property->id,
            'service_id' => $service->id,
        ];

        $response = $this->put(route('expenses.update', $expense), $data);

        $data['id'] = $expense->id;

        $this->assertDatabaseHas('expenses', $data);

        $response->assertRedirect(route('expenses.edit', $expense));
    }

    /**
     * @test
     */
    public function it_deletes_the_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->delete(route('expenses.destroy', $expense));

        $response->assertRedirect(route('expenses.index'));

        $this->assertSoftDeleted($expense);
    }
}
