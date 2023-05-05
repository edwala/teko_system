<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceItemResource;
use App\Http\Resources\InvoiceItemCollection;

class InvoiceInvoiceItemsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        $search = $request->get('search', '');

        $invoiceItems = $invoice
            ->invoiceItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoiceItemCollection($invoiceItems);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Invoice $invoice)
    {
        $this->authorize('create', InvoiceItem::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'item_cost' => ['required', 'numeric'],
            'count' => ['required', 'numeric'],
            'total_cost' => ['required', 'numeric'],
            'vat' => ['required', 'numeric'],
        ]);

        $invoiceItem = $invoice->invoiceItems()->create($validated);

        return new InvoiceItemResource($invoiceItem);
    }
}
