<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EstimateResource;
use App\Http\Resources\EstimateCollection;

class CompanyEstimatesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $estimates = $company
            ->estimates()
            ->search($search)
            ->latest()
            ->paginate();

        return new EstimateCollection($estimates);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', Estimate::class);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'sum' => ['nullable', 'max:255', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'due_date' => ['required', 'date'],
        ]);

        $estimate = $company->estimates()->create($validated);

        return new EstimateResource($estimate);
    }
}
