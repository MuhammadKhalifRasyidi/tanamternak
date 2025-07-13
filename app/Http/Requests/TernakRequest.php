<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TernakRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'    => 'required|string|max:255',
            'jenis' => 'required|string|max:50',
            'berat' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:available,invested,sold',
            'alamat' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'foto' => 'nullable|image|max:2048',
            'tanggal_masuk' => 'required|date'
        ];
    }
}
