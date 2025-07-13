<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bank;
use App\Http\Requests\BankRequest;

class BankController extends Controller
{
    public function IndexBank()
    {
        return response()->json(Bank::all());
    }

    public function StoreBank(BankRequest $request)
    {
        $bank = Bank::create($request->validated());
        return response()->json([
            'message' => 'Bank berhasil ditambahkan', 
            'data' => $bank
        ], 201);
    }

    public function UpdateBank(BankRequest $request, $id)
    {
        $bank = Bank::findOrFail($id);
        $bank->update($request->validated());
        return response()->json([
            'message' => 'Bank berhasil diperbarui', 
            'data' => $bank]);
    }   

    public function DestroyBank($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();
        return response()->json([
            'message' => 'Bank berhasil dihapus']);
    }
}
