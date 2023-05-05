<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid' => [
                'required',
                Rule::unique('companies', 'uuid')->ignore($this->company),
                'max:255',
            ],
            'company_name' => ['required', 'max:255', 'string'],
            'billing_address' => ['required', 'max:255', 'string'],
            'tax_id' => ['required', 'max:255', 'string'],
            'vat_id' => ['nullable', 'max:255', 'string'],
        ];
    }
}
