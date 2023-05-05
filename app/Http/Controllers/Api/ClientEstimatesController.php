<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EstimateResource;
use App\Http\Resources\EstimateCollection;

class ClientEstimatesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {
        $this->authorize('view', $client);

        $search = $request->get('search', '');

        $estimates = $client
            ->estimates()
            ->search($search)
            ->latest()
            ->paginate();

        return new EstimateCollection($estimates);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->authorize('create', Estimate::class);

        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'sum' => ['nullable', 'max:255', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'due_date' => ['required', 'date'],
        ]);

        $estimate = $client->estimates()->create($validated);

        return new EstimateResource($estimate);
    }
}
