<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\InvoiceItem;

use App\Models\Invoice;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceItemTest extends TestCase
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
    public function it_gets_invoice_items_list()
    {
        $invoiceItems = InvoiceItem::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.invoice-items.index'));

        $response->assertOk()->assertSee($invoiceItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_invoice_item()
    {
        $data = InvoiceItem::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.invoice-items.store'), $data);

        $this->assertDatabaseHas('invoice_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_invoice_item()
    {
        $invoiceItem = InvoiceItem::factory()->create();

        $invoice = Invoice::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'item_cost' => $this->faker->randomNumber(1),
            'count' => 0,
            'total_cost' => $this->faker->randomNumber(1),
            'vat' => $this->faker->randomNumber(1),
            'invoice_id' => $invoice->id,
        ];

        $response = $this->putJson(
            route('api.invoice-items.update', $invoiceItem),
            $data
        );

        $data['id'] = $invoiceItem->id;

        $this->assertDatabaseHas('invoice_items', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_invoice_item()
    {
        $invoiceItem = InvoiceItem::factory()->create();

        $response = $this->deleteJson(
            route('api.invoice-items.destroy', $invoiceItem)
        );

        $this->assertSoftDeleted($invoiceItem);

        $response->assertNoContent();
    }
}
