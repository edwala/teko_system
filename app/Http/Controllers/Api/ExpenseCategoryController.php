<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseCategoryResource;
use App\Http\Resources\ExpenseCategoryCollection;
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
            ->paginate();

        return new ExpenseCategoryCollection($expenseCategories);
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

        return new ExpenseCategoryResource($expenseCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ExpenseCategory $expenseCategory)
    {
        $this->authorize('view', $expenseCategory);

        return new ExpenseCategoryResource($expenseCategory);
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

        return new ExpenseCategoryResource($expenseCategory);
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

        return response()->noContent();
    }
}
