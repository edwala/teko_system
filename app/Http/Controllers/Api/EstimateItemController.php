<?php

namespace App\Http\Controllers\Api;

use App\Models\EstimateItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EstimateItemResource;
use App\Http\Resources\EstimateItemCollection;
use App\Http\Requests\EstimateItemStoreRequest;
use App\Http\Requests\EstimateItemUpdateRequest;

class EstimateItemController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', EstimateItem::class);

        $search = $request->get('search', '');

        $estimateItems = EstimateItem::search($search)
            ->latest()
            ->paginate();

        return new EstimateItemCollection($estimateItems);
    }

    /**
     * @param \App\Http\Requests\EstimateItemStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstimateItemStoreRequest $request)
    {
        $this->authorize('create', EstimateItem::class);

        $validated = $request->validated();

        $estimateItem = EstimateItem::create($validated);

        return new EstimateItemResource($estimateItem);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EstimateItem $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EstimateItem $estimateItem)
    {
        $this->authorize('view', $estimateItem);

        return new EstimateItemResource($estimateItem);
    }

    /**
     * @param \App\Http\Requests\EstimateItemUpdateRequest $request
     * @param \App\Models\EstimateItem $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function update(
        EstimateItemUpdateRequest $request,
        EstimateItem $estimateItem
    ) {
        $this->authorize('update', $estimateItem);

        $validated = $request->validated();

        $estimateItem->update($validated);

        return new EstimateItemResource($estimateItem);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EstimateItem $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, EstimateItem $estimateItem)
    {
        $this->authorize('delete', $estimateItem);

        $estimateItem->delete();

        return response()->noContent();
    }
}
