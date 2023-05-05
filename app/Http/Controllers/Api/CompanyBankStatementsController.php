<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankStatementResource;
use App\Http\Resources\BankStatementCollection;

class CompanyBankStatementsController extends Controller
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

        $bankStatements = $company
            ->bankStatements()
            ->search($search)
            ->latest()
            ->paginate();

        return new BankStatementCollection($bankStatements);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', BankStatement::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'file' => ['file', 'max:1024', 'required'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $bankStatement = $company->bankStatements()->create($validated);

        return new BankStatementResource($bankStatement);
    }
}
