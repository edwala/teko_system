<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'file' => ['nullable', 'file'],
            'type' => ['required', 'max:255', 'string'],
            'expense_category_id' => [
                'required',
                'exists:expense_categories,id',
            ],
            'suplier' => ['nullable', 'max:255', 'string'],
            'property_id' => ['nullable', 'exists:properties,id'],
            'service_id' => ['nullable', 'exists:services,id'],
        ];
    }
}
