<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestorRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'    => 'required|string|max:255',
            'nik'     => 'required|string|size:16|unique:investor,nik',
            'alamat' => 'nullable|string',
            'no_hp'   => 'nullable|string|max:20',
            'saldo'   => 'nullable|numeric|min:0',
        ];
    }
}
