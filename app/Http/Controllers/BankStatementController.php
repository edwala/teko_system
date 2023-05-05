<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\BankStatement;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BankStatementStoreRequest;
use App\Http\Requests\BankStatementUpdateRequest;

class BankStatementController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', BankStatement::class);

        $search = $request->get('search', '');

        $bankStatements = BankStatement::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.bank_statements.index',
            compact('bankStatements', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', BankStatement::class);

        $companies = Company::pluck('company_name', 'id');

        return view('app.bank_statements.create', compact('companies'));
    }

    /**
     * @param \App\Http\Requests\BankStatementStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankStatementStoreRequest $request)
    {
        $this->authorize('create', BankStatement::class);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $bankStatement = BankStatement::create($validated);

        return redirect()
            ->route('bank-statements.edit', $bankStatement)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankStatement $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BankStatement $bankStatement)
    {
        $this->authorize('view', $bankStatement);

        return view('app.bank_statements.show', compact('bankStatement'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankStatement $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, BankStatement $bankStatement)
    {
        $this->authorize('update', $bankStatement);

        $companies = Company::pluck('company_name', 'id');

        return view(
            'app.bank_statements.edit',
            compact('bankStatement', 'companies')
        );
    }

    /**
     * @param \App\Http\Requests\BankStatementUpdateRequest $request
     * @param \App\Models\BankStatement $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function update(
        BankStatementUpdateRequest $request,
        BankStatement $bankStatement
    ) {
        $this->authorize('update', $bankStatement);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            if ($bankStatement->file) {
                Storage::delete($bankStatement->file);
            }

            $validated['file'] = $request->file('file')->store('public');
        }

        $bankStatement->update($validated);

        return redirect()
            ->route('bank-statements.edit', $bankStatement)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankStatement $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BankStatement $bankStatement)
    {
        $this->authorize('delete', $bankStatement);

        if ($bankStatement->file) {
            Storage::delete($bankStatement->file);
        }

        $bankStatement->delete();

        return redirect()
            ->route('bank-statements.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
