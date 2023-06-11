<?php

namespace App\Actions\FilamentCompanies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Wallo\FilamentCompanies\Contracts\UpdatesCompanyNames;

class UpdateCompanyName implements UpdatesCompanyNames
{
    /**
     * Validate and update the given company's name.
     *
     * @param  array<string, string>  $input
     *
     * @throws AuthorizationException
     */
    public function update(User $user, Company $company, array $input): void
    {
        Gate::forUser($user)->authorize('update', $company);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'back_code' => ['required', 'int'],
            'account' => ['required', 'int'],
            'billing_address' => ['required', 'string', 'max:255'],
            'tax_id' => ['required', 'string'],
            'vat_id' => ['required', 'string'],
        ])->validateWithBag('updateCompanyName');

        $company->forceFill([
            'name' => $input['name'],
            'back_code' => $input['back_code'],
            'account' => $input['account'],
            'billing_address' => $input['billing_address'],
            'tax_id' => $input['tax_id'],
            'vat_id' => $input['vat_id'],

        ])->save();
    }
}
