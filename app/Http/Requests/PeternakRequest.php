<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeternakRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'    => 'required|string|max:255',
            'nik'     => 'required|string|size:16|unique:peternak,nik',
            'alamat' => 'nullable|string',
            'no_hp'   => 'nullable|string|max:15',
        ];
    }
}
