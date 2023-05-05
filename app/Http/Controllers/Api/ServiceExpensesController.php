<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class ServiceExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Service $service)
    {
        $this->authorize('view', $service);

        $search = $request->get('search', '');

        $expenses = $service
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Service $service)
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
            'property_id' => ['nullable', 'exists:properties,id'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $expense = $service->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
