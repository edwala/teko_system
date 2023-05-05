<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\InvoiceItem;

use App\Models\Invoice;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceItemControllerTest extends TestCase
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
    public function it_displays_index_view_with_invoice_items()
    {
        $invoiceItems = InvoiceItem::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('invoice-items.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.invoice_items.index')
            ->assertViewHas('invoiceItems');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_invoice_item()
    {
        $response = $this->get(route('invoice-items.create'));

        $response->assertOk()->assertViewIs('app.invoice_items.create');
    }

    /**
     * @test
     */
    public function it_stores_the_invoice_item()
    {
        $data = InvoiceItem::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('invoice-items.store'), $data);

        $this->assertDatabaseHas('invoice_items', $data);

        $invoiceItem = InvoiceItem::latest('id')->first();

        $response->assertRedirect(route('invoice-items.edit', $invoiceItem));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_invoice_item()
    {
        $invoiceItem = InvoiceItem::factory()->create();

        $response = $this->get(route('invoice-items.show', $invoiceItem));

        $response
            ->assertOk()
            ->assertViewIs('app.invoice_items.show')
            ->assertViewHas('invoiceItem');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_invoice_item()
    {
        $invoiceItem = InvoiceItem::factory()->create();

        $response = $this->get(route('invoice-items.edit', $invoiceItem));

        $response
            ->assertOk()
            ->assertViewIs('app.invoice_items.edit')
            ->assertViewHas('invoiceItem');
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

        $response = $this->put(
            route('invoice-items.update', $invoiceItem),
            $data
        );

        $data['id'] = $invoiceItem->id;

        $this->assertDatabaseHas('invoice_items', $data);

        $response->assertRedirect(route('invoice-items.edit', $invoiceItem));
    }

    /**
     * @test
     */
    public function it_deletes_the_invoice_item()
    {
        $invoiceItem = InvoiceItem::factory()->create();

        $response = $this->delete(route('invoice-items.destroy', $invoiceItem));

        $response->assertRedirect(route('invoice-items.index'));

        $this->assertSoftDeleted($invoiceItem);
    }
}
