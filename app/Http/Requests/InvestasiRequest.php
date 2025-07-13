<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ternak_id' => 'required|exists:ternak,id',
            'jumlah_unit' => 'required|integer|min:1',
            'total_dana' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:aktif,selesai,gagal',
        ];
    }
}
