<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EstimateItem;

use App\Models\Estimate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EstimateItemTest extends TestCase
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
    public function it_gets_estimate_items_list()
    {
        $estimateItems = EstimateItem::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.estimate-items.index'));

        $response->assertOk()->assertSee($estimateItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_estimate_item()
    {
        $data = EstimateItem::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.estimate-items.store'), $data);

        $this->assertDatabaseHas('estimate_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.estimate-items.update', $estimateItem),
            $data
        );

        $data['id'] = $estimateItem->id;

        $this->assertDatabaseHas('estimate_items', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_estimate_item()
    {
        $estimateItem = EstimateItem::factory()->create();

        $response = $this->deleteJson(
            route('api.estimate-items.destroy', $estimateItem)
        );

        $this->assertModelMissing($estimateItem);

        $response->assertNoContent();
    }
}
