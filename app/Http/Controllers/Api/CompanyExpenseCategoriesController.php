<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseCategoryResource;
use App\Http\Resources\ExpenseCategoryCollection;

class CompanyExpenseCategoriesController extends Controller
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

        $expenseCategories = $company
            ->expenseCategories()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCategoryCollection($expenseCategories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', ExpenseCategory::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
        ]);

        $expenseCategory = $company->expenseCategories()->create($validated);

        return new ExpenseCategoryResource($expenseCategory);
    }
}
