<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;

class CompanyClientsController extends Controller
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

        $clients = $company
            ->clients()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClientCollection($clients);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', Client::class);

        $validated = $request->validate([
            'company_name' => ['required', 'max:255', 'string'],
            'billing_address' => ['required', 'max:255', 'string'],
            'tax_id' => ['required', 'max:255', 'string'],
            'vat_id' => ['nullable', 'max:255', 'string'],
        ]);

        $client = $company->clients()->create($validated);

        return new ClientResource($client);
    }
}
