<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Estimate;

use App\Models\Client;
use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EstimateControllerTest extends TestCase
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
    public function it_displays_index_view_with_estimates()
    {
        $estimates = Estimate::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('estimates.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.estimates.index')
            ->assertViewHas('estimates');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_estimate()
    {
        $response = $this->get(route('estimates.create'));

        $response->assertOk()->assertViewIs('app.estimates.create');
    }

    /**
     * @test
     */
    public function it_stores_the_estimate()
    {
        $data = Estimate::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('estimates.store'), $data);

        $this->assertDatabaseHas('estimates', $data);

        $estimate = Estimate::latest('id')->first();

        $response->assertRedirect(route('estimates.edit', $estimate));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_estimate()
    {
        $estimate = Estimate::factory()->create();

        $response = $this->get(route('estimates.show', $estimate));

        $response
            ->assertOk()
            ->assertViewIs('app.estimates.show')
            ->assertViewHas('estimate');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_estimate()
    {
        $estimate = Estimate::factory()->create();

        $response = $this->get(route('estimates.edit', $estimate));

        $response
            ->assertOk()
            ->assertViewIs('app.estimates.edit')
            ->assertViewHas('estimate');
    }

    /**
     * @test
     */
    public function it_updates_the_estimate()
    {
        $estimate = Estimate::factory()->create();

        $company = Company::factory()->create();
        $client = Client::factory()->create();

        $data = [
            'sum' => $this->faker->text(255),
            'name' => $this->faker->name,
            'due_date' => $this->faker->date,
            'company_id' => $company->id,
            'client_id' => $client->id,
        ];

        $response = $this->put(route('estimates.update', $estimate), $data);

        $data['id'] = $estimate->id;

        $this->assertDatabaseHas('estimates', $data);

        $response->assertRedirect(route('estimates.edit', $estimate));
    }

    /**
     * @test
     */
    public function it_deletes_the_estimate()
    {
        $estimate = Estimate::factory()->create();

        $response = $this->delete(route('estimates.destroy', $estimate));

        $response->assertRedirect(route('estimates.index'));

        $this->assertSoftDeleted($estimate);
    }
}
