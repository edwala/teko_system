<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceItemUpdateRequest extends FormRequest
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
            'invoice_id' => ['required', 'exists:invoices,id'],
            'name' => ['required', 'max:255', 'string'],
            'item_cost' => ['required', 'numeric'],
            'count' => ['required', 'numeric'],
            'total_cost' => ['required', 'numeric'],
            'vat' => ['required', 'numeric'],
        ];
    }
}
