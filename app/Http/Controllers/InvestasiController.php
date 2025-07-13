<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestasiRequest;
use App\Models\Investasi;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class InvestasiController extends Controller
{
    public function IndexInvestasi()
    {
        $user = Auth::guard('api')->user();

        if ($user->role === 'admin') {
            $investasi = Investasi::with(['ternak', 'investor'])->get();
        } else {
            $investor = Investor::where('user_id', $user->id)->first();

            if (!$investor) {
                return response()->json([
                    'message' => 'Investor tidak ditemukan',
                    'status_code' => 404,
                    'data' => null,
                ], 404);
            }

            $investasi = Investasi::where('investor_id', $investor->id)
                ->with(['ternak', 'investor'])
                ->get();

            if ($investasi->isEmpty()) {
                return response()->json([
                    'message' => 'Belum ada data investasi',
                    'status_code' => 404,
                    'data' => [],
                ], 404);
            }
        }

        return response()->json([
            'message' => 'Data investasi ditemukan',
            'status_code' => 200,
            'data' => $investasi,
        ]);
    }

    public function StoreInvestasi(InvestasiRequest $request)
    {
        $user = Auth::guard('api')->user();
        $investor = Investor::where('user_id', $user->id)->first();

        if (!$investor) {
            return response()->json([
                'message' => 'Investor tidak ditemukan',
                'status_code' => 404,
            ], 404);
        }

        $data = $request->validated();
        $data['investor_id'] = $investor->id;

        try {
            $investasi = Investasi::create($data);
            return response()->json([
                'message' => 'Investasi berhasil dibuat',
                'status_code' => 201,
                'data' => $investasi,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat investasi',
                'status_code' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function ShowInvestasi($id)
    {
        $investasi = Investasi::with(['ternak', 'investor'])->find($id);

        if (!$investasi) {
            return response()->json([
                'message' => 'Investasi tidak ditemukan',
                'status_code' => 404,
                'data' => null,
            ], 404);
        }

        return response()->json([
            'message' => 'Detail investasi ditemukan',
            'status_code' => 200,
            'data' => $investasi,
        ]);
    }

    public function UpdateInvestasi(InvestasiRequest $request, $id)
    {
        $investasi = Investasi::find($id);

        if (!$investasi) {
            return response()->json([
                'message' => 'Investasi tidak ditemukan',
                'status_code' => 404,
            ], 404);
        }

        $data = $request->validated();

        try {
            $investasi->update($data);

            return response()->json([
                'message' => 'Investasi berhasil diperbarui',
                'status_code' => 200,
                'data' => $investasi,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui investasi',
                'status_code' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function DestroyInvestasi($id)
    {
        $investasi = Investasi::find($id);

        if (!$investasi) {
            return response()->json([
                'message' => 'Investasi tidak ditemukan',
                'status_code' => 404,
            ], 404);
        }

        try {
            $investasi->delete();

            return response()->json([
                'message' => 'Investasi berhasil dihapus',
                'status_code' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus investasi',
                'status_code' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
