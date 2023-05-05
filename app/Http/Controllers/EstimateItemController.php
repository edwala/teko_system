<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\EstimateItem;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.estimate_items.index',
            compact('estimateItems', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', EstimateItem::class);

        $estimates = Estimate::pluck('name', 'id');

        return view('app.estimate_items.create', compact('estimates'));
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

        return redirect()
            ->route('estimate-items.edit', $estimateItem)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EstimateItem $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EstimateItem $estimateItem)
    {
        $this->authorize('view', $estimateItem);

        return view('app.estimate_items.show', compact('estimateItem'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EstimateItem $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, EstimateItem $estimateItem)
    {
        $this->authorize('update', $estimateItem);

        $estimates = Estimate::pluck('name', 'id');

        return view(
            'app.estimate_items.edit',
            compact('estimateItem', 'estimates')
        );
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

        return redirect()
            ->route('estimate-items.edit', $estimateItem)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('estimate-items.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
