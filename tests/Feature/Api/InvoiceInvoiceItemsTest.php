<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceItem;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceInvoiceItemsTest extends TestCase
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
    public function it_gets_invoice_invoice_items()
    {
        $invoice = Invoice::factory()->create();
        $invoiceItems = InvoiceItem::factory()
            ->count(2)
            ->create([
                'invoice_id' => $invoice->id,
            ]);

        $response = $this->getJson(
            route('api.invoices.invoice-items.index', $invoice)
        );

        $response->assertOk()->assertSee($invoiceItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_invoice_invoice_items()
    {
        $invoice = Invoice::factory()->create();
        $data = InvoiceItem::factory()
            ->make([
                'invoice_id' => $invoice->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.invoices.invoice-items.store', $invoice),
            $data
        );

        $this->assertDatabaseHas('invoice_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $invoiceItem = InvoiceItem::latest('id')->first();

        $this->assertEquals($invoice->id, $invoiceItem->invoice_id);
    }
}
