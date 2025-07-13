<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis' => 'required|in:investasi,deposit,withdraw',
            'jumlah' => 'required|numeric|min:0',
            'status' => 'required|in:pending,selesai,gagal',
            'catatan' => 'nullable|string'
        ];
    }
}
