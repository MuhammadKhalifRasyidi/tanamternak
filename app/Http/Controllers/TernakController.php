<?php

namespace App\Http\Controllers;

use App\Http\Requests\TernakRequest;
use App\Models\Ternak;
use App\Models\Peternak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Exception;

class TernakController extends Controller
{
    public function IndexTernak()
    {
        $user = Auth::guard('api')->user();
        $peternak = Peternak::where('user_id', $user->id)->first();

        if (!$peternak) {
            return response()->json([
                'message' => 'Profil peternak tidak ditemukan',
                'status_code' => 404,
                'data' => null
            ], 404);
        }

        $ternak = Ternak::where('peternak_id', $peternak->id)->get();

        if ($ternak->isEmpty()) {
            return response()->json([
                'message' => 'Belum ada data ternak yang dimiliki',
                'status_code' => 404,
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Data ternak ditemukan',
            'status_code' => 200,
            'data' => $ternak
        ]);
    }

    public function MarketTernak()
    {
        $ternak = Ternak::with('peternak')->get();

        if ($ternak->isEmpty()) {
            return response()->json([
                'message' => 'Belum ada data ternak tersedia',
                'status_code' => 404,
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Data semua ternak tersedia',
            'status_code' => 200,
            'data' => $ternak
        ]);
    }


    public function StoreTernak(TernakRequest $request)
    {
        $user = Auth::guard('api')->user();
        $peternak = Peternak::where('user_id', $user->id)->first();

        if (!$peternak) {
            return response()->json(['message' => 'Peternak tidak ditemukan'], 404);
        }

        $data = $request->validated();
        $data['peternak_id'] = $peternak->id;
        $data['berat_awal'] = $data['berat'];
        unset($data['berat']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ternak', 'public');
        }

        $ternak = Ternak::create($data);

        return response()->json([
            'message' => 'Ternak berhasil ditambahkan',
            'status_code' => 201,
            'data' => $ternak
        ], 201);
    }

    public function ShowTernak($id)
    {
        $ternak = Ternak::find($id);

        if (!$ternak) {
            return response()->json([
                'message' => 'Ternak tidak ditemukan',
                'status_code' => 404,
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Detail ternak ditemukan',
            'status_code' => 200,
            'data' => $ternak
        ]);
    }

    public function UpdateTernak(TernakRequest $request, $id)
    {
        $ternak = Ternak::find($id);

        if (!$ternak) {
            return response()->json([
                'message' => 'Ternak tidak ditemukan',
                'status_code' => 404,
                'data' => null
            ], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($ternak->foto) {
                Storage::disk('public')->delete($ternak->foto);
            }
            $data['foto'] = $request->file('foto')->store('ternak', 'public');
        }

        $ternak->update($data);

        return response()->json([
            'message' => 'Ternak berhasil diperbarui',
            'status_code' => 200,
            'data' => $ternak
        ]);
    }

    public function DestroyTernak($id)
    {
        $ternak = Ternak::find($id);

        if (!$ternak) {
            return response()->json([
                'message' => 'Ternak tidak ditemukan',
                'status_code' => 404,
            ], 404);
        }

        if ($ternak->foto) {
            Storage::disk('public')->delete($ternak->foto);
        }

        $ternak->delete();

        return response()->json([
            'message' => 'Ternak berhasil dihapus',
            'status_code' => 200,
        ]);
    }
}