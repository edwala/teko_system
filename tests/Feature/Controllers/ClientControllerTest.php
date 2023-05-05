<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Client;

use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientControllerTest extends TestCase
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
    public function it_displays_index_view_with_clients()
    {
        $clients = Client::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('clients.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.clients.index')
            ->assertViewHas('clients');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_client()
    {
        $response = $this->get(route('clients.create'));

        $response->assertOk()->assertViewIs('app.clients.create');
    }

    /**
     * @test
     */
    public function it_stores_the_client()
    {
        $data = Client::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('clients.store'), $data);

        $this->assertDatabaseHas('clients', $data);

        $client = Client::latest('id')->first();

        $response->assertRedirect(route('clients.edit', $client));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_client()
    {
        $client = Client::factory()->create();

        $response = $this->get(route('clients.show', $client));

        $response
            ->assertOk()
            ->assertViewIs('app.clients.show')
            ->assertViewHas('client');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_client()
    {
        $client = Client::factory()->create();

        $response = $this->get(route('clients.edit', $client));

        $response
            ->assertOk()
            ->assertViewIs('app.clients.edit')
            ->assertViewHas('client');
    }

    /**
     * @test
     */
    public function it_updates_the_client()
    {
        $client = Client::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'company_name' => $this->faker->text(255),
            'billing_address' => $this->faker->text(255),
            'tax_id' => $this->faker->text(255),
            'vat_id' => $this->faker->text(255),
            'company_id' => $company->id,
        ];

        $response = $this->put(route('clients.update', $client), $data);

        $data['id'] = $client->id;

        $this->assertDatabaseHas('clients', $data);

        $response->assertRedirect(route('clients.edit', $client));
    }

    /**
     * @test
     */
    public function it_deletes_the_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));

        $this->assertSoftDeleted($client);
    }
}
