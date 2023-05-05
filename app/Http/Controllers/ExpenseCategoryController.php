<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Requests\ExpenseCategoryStoreRequest;
use App\Http\Requests\ExpenseCategoryUpdateRequest;

class ExpenseCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ExpenseCategory::class);

        $search = $request->get('search', '');

        $expenseCategories = ExpenseCategory::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.expense_categories.index',
            compact('expenseCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ExpenseCategory::class);

        $companies = Company::pluck('company_name', 'id');

        return view('app.expense_categories.create', compact('companies'));
    }

    /**
     * @param \App\Http\Requests\ExpenseCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseCategoryStoreRequest $request)
    {
        $this->authorize('create', ExpenseCategory::class);

        $validated = $request->validated();

        $expenseCategory = ExpenseCategory::create($validated);

        return redirect()
            ->route('expense-categories.edit', $expenseCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ExpenseCategory $expenseCategory)
    {
        $this->authorize('view', $expenseCategory);

        return view('app.expense_categories.show', compact('expenseCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ExpenseCategory $expenseCategory)
    {
        $this->authorize('update', $expenseCategory);

        $companies = Company::pluck('company_name', 'id');

        return view(
            'app.expense_categories.edit',
            compact('expenseCategory', 'companies')
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseCategoryUpdateRequest $request
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        ExpenseCategoryUpdateRequest $request,
        ExpenseCategory $expenseCategory
    ) {
        $this->authorize('update', $expenseCategory);

        $validated = $request->validated();

        $expenseCategory->update($validated);

        return redirect()
            ->route('expense-categories.edit', $expenseCategory)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ExpenseCategory $expenseCategory)
    {
        $this->authorize('delete', $expenseCategory);

        $expenseCategory->delete();

        return redirect()
            ->route('expense-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
