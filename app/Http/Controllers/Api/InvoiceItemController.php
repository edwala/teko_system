<?php

namespace App\Http\Controllers\Api;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceItemResource;
use App\Http\Resources\InvoiceItemCollection;
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
            ->paginate();

        return new InvoiceItemCollection($invoiceItems);
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

        return new InvoiceItemResource($invoiceItem);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoiceItem $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, InvoiceItem $invoiceItem)
    {
        $this->authorize('view', $invoiceItem);

        return new InvoiceItemResource($invoiceItem);
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

        return new InvoiceItemResource($invoiceItem);
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

        return response()->noContent();
    }
}
