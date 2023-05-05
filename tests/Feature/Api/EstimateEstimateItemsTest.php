<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Estimate;
use App\Models\EstimateItem;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EstimateEstimateItemsTest extends TestCase
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
    public function it_gets_estimate_estimate_items()
    {
        $estimate = Estimate::factory()->create();
        $estimateItems = EstimateItem::factory()
            ->count(2)
            ->create([
                'estimate_id' => $estimate->id,
            ]);

        $response = $this->getJson(
            route('api.estimates.estimate-items.index', $estimate)
        );

        $response->assertOk()->assertSee($estimateItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_estimate_estimate_items()
    {
        $estimate = Estimate::factory()->create();
        $data = EstimateItem::factory()
            ->make([
                'estimate_id' => $estimate->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.estimates.estimate-items.store', $estimate),
            $data
        );

        $this->assertDatabaseHas('estimate_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $estimateItem = EstimateItem::latest('id')->first();

        $this->assertEquals($estimate->id, $estimateItem->estimate_id);
    }
}
