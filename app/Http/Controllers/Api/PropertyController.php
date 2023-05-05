<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\PropertyCollection;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;

class PropertyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Property::class);

        $search = $request->get('search', '');

        $properties = Property::search($search)
            ->latest()
            ->paginate();

        return new PropertyCollection($properties);
    }

    /**
     * @param \App\Http\Requests\PropertyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyStoreRequest $request)
    {
        $this->authorize('create', Property::class);

        $validated = $request->validated();

        $property = Property::create($validated);

        return new PropertyResource($property);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Property $property)
    {
        $this->authorize('view', $property);

        return new PropertyResource($property);
    }

    /**
     * @param \App\Http\Requests\PropertyUpdateRequest $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyUpdateRequest $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validated();

        $property->update($validated);

        return new PropertyResource($property);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Property $property)
    {
        $this->authorize('delete', $property);

        $property->delete();

        return response()->noContent();
    }
}
