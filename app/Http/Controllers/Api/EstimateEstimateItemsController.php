<?php

namespace App\Http\Controllers\Api;

use App\Models\Estimate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EstimateItemResource;
use App\Http\Resources\EstimateItemCollection;

class EstimateEstimateItemsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Estimate $estimate
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Estimate $estimate)
    {
        $this->authorize('view', $estimate);

        $search = $request->get('search', '');

        $estimateItems = $estimate
            ->estimateItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new EstimateItemCollection($estimateItems);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Estimate $estimate
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Estimate $estimate)
    {
        $this->authorize('create', EstimateItem::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'item_cost' => ['required', 'numeric'],
            'count' => ['required', 'numeric'],
            'total_cost' => ['required', 'numeric'],
            'vat' => ['required', 'numeric'],
        ]);

        $estimateItem = $estimate->estimateItems()->create($validated);

        return new EstimateItemResource($estimateItem);
    }
}
