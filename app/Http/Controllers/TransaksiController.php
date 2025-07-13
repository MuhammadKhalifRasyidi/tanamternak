<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiRequest;
use App\Models\Investor;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function StoreTransaksi(TransaksiRequest $request)
    {
        $user = Auth::guard('api')->user();
        $investor = Investor::where('user_id', $user->id)->first();

        if (!$investor) {
            return response()->json([
                'message' => 'Investor tidak ditemukan',
                'status_code' => 404,
                'data' => null,
            ], 404);
        }

        $data = $request->validated();
        $data['investor_id'] = $investor->id;

        // Update saldo investor
        if ($data['jenis'] === 'deposit') {
            $investor->saldo += $data['jumlah'];
        } elseif (in_array($data['jenis'], ['withdraw', 'investasi'])) {
            if ($investor->saldo < $data['jumlah']) {
                return response()->json([
                    'message' => 'Saldo tidak mencukupi',
                    'status_code' => 400,
                ], 400);
            }
            $investor->saldo -= $data['jumlah'];
        }

        $investor->save();
        $transaksi = Transaksi::create($data);

        return response()->json([
            'message' => 'Transaksi berhasil',
            'data' => $transaksi,
        ], 201);
    }

    public function IndexTransaksi()
    {
        $user = Auth::guard('api')->user();
        $investor = Investor::where('user_id', $user->id)->first();

        if (!$investor) {
            return response()->json([
                'message' => 'Investor tidak ditemukan',
                'status_code' => 404,
            ], 404);
        }

        $transaksi = Transaksi::where('investor_id', $investor->id)->latest()->get();

        if ($transaksi->isEmpty()) {
            return response()->json([
                'message' => 'Belum ada transaksi',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Daftar transaksi ditemukan',
            'data' => $transaksi,
        ], 200);
    }
}
