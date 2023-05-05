<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BankStatement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BankStatementResource;
use App\Http\Resources\BankStatementCollection;
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
            ->paginate();

        return new BankStatementCollection($bankStatements);
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

        return new BankStatementResource($bankStatement);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankStatement $bankStatement
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BankStatement $bankStatement)
    {
        $this->authorize('view', $bankStatement);

        return new BankStatementResource($bankStatement);
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

        return new BankStatementResource($bankStatement);
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

        return response()->noContent();
    }
}
