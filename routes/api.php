<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\InvestasiController;
use Illuminate\Http\Request;
use App\Models\Investor;
use App\Models\Investasi;
use App\Models\Peternak;
use App\Models\Transaksi;
use App\Models\Bank;
use App\Http\Controllers\TernakController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/bank', [BankController::class, 'IndexBank']);
    Route::get('ternak', [TernakController::class, 'IndexTernak']);
    Route::get('ternak/{id}', [TernakController::class, 'ShowTernak']);

    Route::get('market/ternak', [TernakController::class, 'MarketTernak']);
});

//ADMIN
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('admin/profile', [ProfileController::class, 'adminProfile']);
    Route::get('admin/profile-get', [ProfileController::class, 'getAdminProfile']);

    // BANK
    Route::post('/bank', [BankController::class, 'StoreBank']);
    Route::put('/bank/{id}', [BankController::class, 'UpdateBank']);
    Route::delete('/bank/{id}', [BankController::class, 'DestroyBank']);

    //INVESTASI
    Route::get('/admin/investasi', [InvestasiController::class, 'IndexInvestasi']);
    Route::get('/admin/investasi/{id}', [InvestasiController::class, 'ShowInvestasi']);
});

//INVESTOR
Route::middleware(['auth:api', 'role:investor'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('investor/profile', [ProfileController::class, 'StoreInvestor']);
    Route::get('investor/profile', [ProfileController::class, 'IndexInvestor']);

    //TRANSAKSI
    Route::post('/transaksi', [TransaksiController::class, 'StoreTransaksi']);
    Route::get('/transaksi', [TransaksiController::class, 'IndexTransaksi']);

    //INVESTASI
    Route::post('/investasi', [InvestasiController::class, 'StoreInvestasi']);
    Route::get('/investasi', [InvestasiController::class, 'IndexInvestasi']);
    Route::get('/investasi/{id}', [InvestasiController::class, 'ShowInvestasi']);
    Route::put('/investasi/{id}', [InvestasiController::class, 'UpdateInvestasi']);
    Route::delete('/investasi/{id}', [InvestasiController::class, 'DestroyInvestasi']);
});

//PETERNAK
Route::middleware(['auth:api', 'role:peternak'])->group(function () {
    Route::post('peternak/profile', [ProfileController::class, 'StorePeternak']);
    Route::get('peternak/profile', [ProfileController::class, 'IndexPeternak']);

    //TERNAK
    Route::post('ternak', [TernakController::class, 'StoreTernak']);
    Route::put('ternak/{id}', [TernakController::class, 'UpdateTernak']);
    Route::delete('ternak/{id}', [TernakController::class, 'DestroyTernak']);
});
