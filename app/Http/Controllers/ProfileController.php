<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AddAdminRequest;
use App\Http\Requests\InvestorRequest;
use App\Http\Requests\PeternakRequest;
use App\Models\Admin;
use App\Models\User;
use App\Models\Peternak;
use App\Models\Investor;

class ProfileController extends Controller
{
    public function AdminProfile(AddAdminRequest $request)
    {

        try {
            $user = Auth::guard('api')->user();
            if (Admin::where('user_id', $user->id)->exists()) {
                return response()->json([
                    'message' => 'Profil admin sudah ada',
                    'status_code' => 409,
                    'data' => null
                ], 409);
            }
            $admin = new Admin();
            $admin->user_id = $user->id;
            $admin->name = $request->name;
            $admin->save();

            return response()->json([
                'message' => 'Profil admin berhasil dibuat',
                'status_code' => 201,
                'data' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Internal Server Error: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    public function getAdminProfile()
    {
        try {
            $user = Auth::guard('api')->user();
            $admin = Admin::where('user_id', $user->id)->first();

            if (!$admin) {
                return response()->json([
                    'message' => 'Profil admin tidak ditemukan',
                    'status_code' => 404,
                    'data' => null
                ], 404);
            }

            return response()->json([
                'message' => 'Profil admin ditemukan',
                'status_code' => 200,
                'data' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Internal Server Error: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    public function StoreInvestor(InvestorRequest $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        if (Investor::where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Profil investor sudah ada',
                'status_code' => 409,
                'data' => null
            ], 409);
        }

        $data = $request->validated();
        $data['user_id'] = $user->id;

        $investor = Investor::create($data);

        return response()->json([
            'message' => 'Profil investor berhasil disimpan',
            'data' => $investor
        ], 201);
    }

    public function IndexInvestor()
    {
        $user = Auth::guard('api')->user();

        $investor = Investor::where('user_id', $user->id)->first();

        if (!$investor) {
            return response()->json([
                'message' => 'Profil investor tidak ditemukan',
                'status_code' => 404,
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Profil investor ditemukan',
            'data' => $investor
        ]);
    }

    public function IndexPeternak()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
                'status_code' => 401,
                'data' => null
            ], 401);
        }

        $peternak = Peternak::where('user_id', $user->id)->first();

        if (!$peternak) {
            return response()->json([
                'message' => 'Profil peternak tidak ditemukan',
                'status_code' => 404,
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Profil peternak ditemukan',
            'data' => $peternak
        ]);
    }


    public function StorePeternak(PeternakRequest $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        if (Peternak::where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Profil peternak sudah ada',
                'status_code' => 409,
                'data' => null
            ], 409);
        }

        $data = $request->validated();
        $data['user_id'] = $user->id;

        $peternak = Peternak::create($data);

        return response()->json([
            'message' => 'Profil peternak berhasil disimpan',
            'data' => $peternak
        ], 201);
    }
}
