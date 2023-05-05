<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceItemStoreRequest;
use App\Http\Requests\InvoiceItemUpdateRequest;

class InvoiceItemController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', InvoiceItem::class);

        $search = $request->get('search', '');

        $invoiceItems = InvoiceItem::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.invoice_items.index',
            compact('invoiceItems', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', InvoiceItem::class);

        $invoices = Invoice::pluck('name', 'id');

        return view('app.invoice_items.create', compact('invoices'));
    }

    /**
     * @param \App\Http\Requests\InvoiceItemStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceItemStoreRequest $request)
    {
        $this->authorize('create', InvoiceItem::class);

        $validated = $request->validated();

        $invoiceItem = InvoiceItem::create($validated);

        return redirect()
            ->route('invoice-items.edit', $invoiceItem)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, InvoiceItem $invoiceItem)
    {
        $this->authorize('view', $invoiceItem);

        return view('app.invoice_items.show', compact('invoiceItem'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, InvoiceItem $invoiceItem)
    {
        $this->authorize('update', $invoiceItem);

        $invoices = Invoice::pluck('name', 'id');

        return view(
            'app.invoice_items.edit',
            compact('invoiceItem', 'invoices')
        );
    }

    /**
     * @param \App\Http\Requests\InvoiceItemUpdateRequest $request
     * @param \App\Models\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function update(
        InvoiceItemUpdateRequest $request,
        InvoiceItem $invoiceItem
    ) {
        $this->authorize('update', $invoiceItem);

        $validated = $request->validated();

        $invoiceItem->update($validated);

        return redirect()
            ->route('invoice-items.edit', $invoiceItem)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, InvoiceItem $invoiceItem)
    {
        $this->authorize('delete', $invoiceItem);

        $invoiceItem->delete();

        return redirect()
            ->route('invoice-items.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
