<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Models\Estimate;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.estimates.index', compact('estimates', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Estimate::class);

        $companies = Company::pluck('company_name', 'id');
        $clients = Client::pluck('company_name', 'id');

        return view('app.estimates.create', compact('companies', 'clients'));
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

        return redirect()
            ->route('estimates.edit', $estimate)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Estimate $estimate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Estimate $estimate)
    {
        $this->authorize('view', $estimate);

        return view('app.estimates.show', compact('estimate'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Estimate $estimate
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Estimate $estimate)
    {
        $this->authorize('update', $estimate);

        $companies = Company::pluck('company_name', 'id');
        $clients = Client::pluck('company_name', 'id');

        return view(
            'app.estimates.edit',
            compact('estimate', 'companies', 'clients')
        );
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

        return redirect()
            ->route('estimates.edit', $estimate)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('estimates.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
