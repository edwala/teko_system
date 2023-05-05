<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class PropertyExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Property $property)
    {
        $this->authorize('view', $property);

        $search = $request->get('search', '');

        $expenses = $property
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Property $property)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'name' => ['required', 'max:255', 'string'],
            'file' => ['nullable', 'file'],
            'type' => ['required', 'max:255', 'string'],
            'expense_category_id' => [
                'required',
                'exists:expense_categories,id',
            ],
            'suplier' => ['nullable', 'max:255', 'string'],
            'service_id' => ['nullable', 'exists:services,id'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $expense = $property->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
