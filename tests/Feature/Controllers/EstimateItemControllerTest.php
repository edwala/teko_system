<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\EstimateItem;

use App\Models\Estimate;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EstimateItemControllerTest extends TestCase
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
    public function it_displays_index_view_with_estimate_items()
    {
        $estimateItems = EstimateItem::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('estimate-items.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.estimate_items.index')
            ->assertViewHas('estimateItems');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_estimate_item()
    {
        $response = $this->get(route('estimate-items.create'));

        $response->assertOk()->assertViewIs('app.estimate_items.create');
    }

    /**
     * @test
     */
    public function it_stores_the_estimate_item()
    {
        $data = EstimateItem::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('estimate-items.store'), $data);

        $this->assertDatabaseHas('estimate_items', $data);

        $estimateItem = EstimateItem::latest('id')->first();

        $response->assertRedirect(route('estimate-items.edit', $estimateItem));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_estimate_item()
    {
        $estimateItem = EstimateItem::factory()->create();

        $response = $this->get(route('estimate-items.show', $estimateItem));

        $response
            ->assertOk()
            ->assertViewIs('app.estimate_items.show')
            ->assertViewHas('estimateItem');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_estimate_item()
    {
        $estimateItem = EstimateItem::factory()->create();

        $response = $this->get(route('estimate-items.edit', $estimateItem));

        $response
            ->assertOk()
            ->assertViewIs('app.estimate_items.edit')
            ->assertViewHas('estimateItem');
    }

    /**
     * @test
     */
    public function it_updates_the_estimate_item()
    {
        $estimateItem = EstimateItem::factory()->create();

        $estimate = Estimate::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'item_cost' => $this->faker->randomNumber(1),
            'count' => 0,
            'total_cost' => $this->faker->randomNumber(1),
            'vat' => $this->faker->randomNumber(1),
            'estimate_id' => $estimate->id,
        ];

        $response = $this->put(
            route('estimate-items.update', $estimateItem),
            $data
        );

        $data['id'] = $estimateItem->id;

        $this->assertDatabaseHas('estimate_items', $data);

        $response->assertRedirect(route('estimate-items.edit', $estimateItem));
    }

    /**
     * @test
     */
    public function it_deletes_the_estimate_item()
    {
        $estimateItem = EstimateItem::factory()->create();

        $response = $this->delete(
            route('estimate-items.destroy', $estimateItem)
        );

        $response->assertRedirect(route('estimate-items.index'));

        $this->assertModelMissing($estimateItem);
    }
}
