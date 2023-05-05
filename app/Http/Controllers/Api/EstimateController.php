<?php

namespace App\Http\Controllers\Api;

use App\Models\Estimate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EstimateResource;
use App\Http\Resources\EstimateCollection;
use App\Http\Requests\EstimateStoreRequest;
use App\Http\Requests\EstimateUpdateRequest;

class EstimateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Estimate::class);

        $search = $request->get('search', '');

        $estimates = Estimate::search($search)
            ->latest()
            ->paginate();

        return new EstimateCollection($estimates);
    }

    /**
     * @param \App\Http\Requests\EstimateStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstimateStoreRequest $request)
    {
        $this->authorize('create', Estimate::class);

        $validated = $request->validated();

        $estimate = Estimate::create($validated);

        return new EstimateResource($estimate);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Estimate $estimate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Estimate $estimate)
    {
        $this->authorize('view', $estimate);

        return new EstimateResource($estimate);
    }

    /**
     * @param \App\Http\Requests\EstimateUpdateRequest $request
     * @param \App\Models\Estimate $estimate
     * @return \Illuminate\Http\Response
     */
    public function update(EstimateUpdateRequest $request, Estimate $estimate)
    {
        $this->authorize('update', $estimate);

        $validated = $request->validated();

        $estimate->update($validated);

        return new EstimateResource($estimate);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Estimate $estimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Estimate $estimate)
    {
        $this->authorize('delete', $estimate);

        $estimate->delete();

        return response()->noContent();
    }
}
