<?php

namespace App\Actions\FilamentCompanies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Wallo\FilamentCompanies\Contracts\RemovesCompanyEmployees;
use Wallo\FilamentCompanies\Events\CompanyEmployeeRemoved;

class RemoveCompanyEmployee implements RemovesCompanyEmployees
{
    /**
     * Remove the company employee from the given company.
     *
     */
    public function remove(User $user, Company $company, User $companyEmployee): void
    {
        $this->authorize($user, $company, $companyEmployee);

        $this->ensureUserDoesNotOwnCompany($companyEmployee, $company);

        $company->removeUser($companyEmployee);

        CompanyEmployeeRemoved::dispatch($company, $companyEmployee);
    }

    /**
     * Authorize that the user can remove the company employee.
     *
     */
    protected function authorize(User $user, Company $company, User $companyEmployee): void
    {
        if (! Gate::forUser($user)->check('removeCompanyEmployee', $company) &&
            $user->id !== $companyEmployee->id) {
            throw new AuthorizationException;
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the company.
     *
     */
    protected function ensureUserDoesNotOwnCompany(User $companyEmployee, Company $company): void
    {
        if ($companyEmployee->id === $company->owner->id) {
            throw ValidationException::withMessages([
                'company' => [__('You may not leave a company that you created.')],
            ])->errorBag('removeCompanyEmployee');
        }
    }
}
