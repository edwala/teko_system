<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankStatementStoreRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'file' => ['file', 'max:1024', 'required'],
        ];
    }
}
