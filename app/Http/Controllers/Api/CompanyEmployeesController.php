<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeCollection;

class CompanyEmployeesController extends Controller
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

        $employees = $company
            ->employees()
            ->search($search)
            ->latest()
            ->paginate();

        return new EmployeeCollection($employees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', Employee::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'surname' => ['required', 'max:255', 'string'],
            'address' => ['required', 'max:255', 'string'],
            'position' => ['nullable', 'max:255', 'string'],
        ]);

        $employee = $company->employees()->create($validated);

        return new EmployeeResource($employee);
    }
}
