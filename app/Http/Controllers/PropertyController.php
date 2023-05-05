<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Property;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.properties.index', compact('properties', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Property::class);

        $companies = Company::pluck('company_name', 'id');

        return view('app.properties.create', compact('companies'));
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

        return redirect()
            ->route('properties.edit', $property)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Property $property)
    {
        $this->authorize('view', $property);

        return view('app.properties.show', compact('property'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $companies = Company::pluck('company_name', 'id');

        return view('app.properties.edit', compact('property', 'companies'));
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

        return redirect()
            ->route('properties.edit', $property)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('properties.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
