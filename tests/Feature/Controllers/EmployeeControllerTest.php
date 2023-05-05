<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Employee;

use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeControllerTest extends TestCase
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
    public function it_displays_index_view_with_employees()
    {
        $employees = Employee::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('employees.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.employees.index')
            ->assertViewHas('employees');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_employee()
    {
        $response = $this->get(route('employees.create'));

        $response->assertOk()->assertViewIs('app.employees.create');
    }

    /**
     * @test
     */
    public function it_stores_the_employee()
    {
        $data = Employee::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('employees.store'), $data);

        $this->assertDatabaseHas('employees', $data);

        $employee = Employee::latest('id')->first();

        $response->assertRedirect(route('employees.edit', $employee));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.show', $employee));

        $response
            ->assertOk()
            ->assertViewIs('app.employees.show')
            ->assertViewHas('employee');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.edit', $employee));

        $response
            ->assertOk()
            ->assertViewIs('app.employees.edit')
            ->assertViewHas('employee');
    }

    /**
     * @test
     */
    public function it_updates_the_employee()
    {
        $employee = Employee::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'address' => $this->faker->address,
            'position' => $this->faker->text(255),
            'company_id' => $company->id,
        ];

        $response = $this->put(route('employees.update', $employee), $data);

        $data['id'] = $employee->id;

        $this->assertDatabaseHas('employees', $data);

        $response->assertRedirect(route('employees.edit', $employee));
    }

    /**
     * @test
     */
    public function it_deletes_the_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employees.destroy', $employee));

        $response->assertRedirect(route('employees.index'));

        $this->assertSoftDeleted($employee);
    }
}
