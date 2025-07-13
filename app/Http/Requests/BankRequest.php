<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'code' => ['required','string','max:10',
                Rule::unique('bank', 'code')->ignore($this->route('id')),
            ],
            'no_rekening' => 'nullable|string|max:50',
        ];
    }
}
