<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceCollection;

class CompanyInvoicesController extends Controller
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

        $invoices = $company
            ->invoices()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoiceCollection($invoices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', Invoice::class);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'number' => ['required', 'max:255', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'due_date' => ['required', 'date'],
        ]);

        $invoice = $company->invoices()->create($validated);

        return new InvoiceResource($invoice);
    }
}
