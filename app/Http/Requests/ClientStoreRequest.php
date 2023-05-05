<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'company_id' => ['required', 'exists:companies,id'],
            'company_name' => ['required', 'max:255', 'string'],
            'billing_address' => ['required', 'max:255', 'string'],
            'tax_id' => ['required', 'max:255', 'string'],
            'vat_id' => ['nullable', 'max:255', 'string'],
        ];
    }
}
