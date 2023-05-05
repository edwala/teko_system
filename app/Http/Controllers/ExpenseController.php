<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Company;
use App\Models\Service;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;

class ExpenseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Expense::class);

        $search = $request->get('search', '');

        $expenses = Expense::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.expenses.index', compact('expenses', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Expense::class);

        $companies = Company::pluck('company_name', 'id');
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $properties = Property::pluck('name', 'id');
        $services = Service::pluck('name', 'id');

        return view(
            'app.expenses.create',
            compact('companies', 'expenseCategories', 'properties', 'services')
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $expense = Expense::create($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expense $expense)
    {
        $this->authorize('view', $expense);

        return view('app.expenses.show', compact('expense'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $companies = Company::pluck('company_name', 'id');
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $properties = Property::pluck('name', 'id');
        $services = Service::pluck('name', 'id');

        return view(
            'app.expenses.edit',
            compact(
                'expense',
                'companies',
                'expenseCategories',
                'properties',
                'services'
            )
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseUpdateRequest $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseUpdateRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            if ($expense->file) {
                Storage::delete($expense->file);
            }

            $validated['file'] = $request->file('file')->store('public');
        }

        $expense->update($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Expense $expense)
    {
        $this->authorize('delete', $expense);

        if ($expense->file) {
            Storage::delete($expense->file);
        }

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
