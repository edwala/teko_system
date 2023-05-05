<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class ExpenseCategoryExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ExpenseCategory $expenseCategory)
    {
        $this->authorize('view', $expenseCategory);

        $search = $request->get('search', '');

        $expenses = $expenseCategory
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ExpenseCategory $expenseCategory)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'name' => ['required', 'max:255', 'string'],
            'file' => ['nullable', 'file'],
            'type' => ['required', 'max:255', 'string'],
            'suplier' => ['nullable', 'max:255', 'string'],
            'property_id' => ['nullable', 'exists:properties,id'],
            'service_id' => ['nullable', 'exists:services,id'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $expense = $expenseCategory->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
