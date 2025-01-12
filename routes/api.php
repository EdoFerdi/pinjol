<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrangController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\PembayaranController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('orang', [OrangController::class, 'getOrang']);
Route::post('orang', [OrangController::class, 'storeOrang']);
Route::delete('orang/{id}', [OrangController::class, 'destroyOrang']);
Route::get('orang/{id}', [OrangController::class, 'getOrangById']);
Route::put('orang/{id}', [OrangController::class, 'updateOrang']); 

Route::get('pinjaman', [PinjamanController::class, 'getPinjaman']);
Route::post('pinjaman', [PinjamanController::class, 'storePinjaman']);
Route::delete('pinjaman/{id}', [PinjamanController::class, 'destroyPinjaman']);
Route::get('/pinjaman/{id}', [PinjamanController::class, 'getPinjamanById']);
Route::put('pinjaman/{id}', [PinjamanController::class, 'updatePinjaman']);

Route::get('pembayaran', [PembayaranController::class, 'getPembayaran']);
Route::post('pembayaran', [PembayaranController::class, 'storePembayaran']);
Route::delete('pembayaran/{id}', [PembayaranController::class, 'destroyPembayaran']);
Route::get('pembayaran/{id}', [PembayaranController::class, 'getPinjamanById']);
Route::put('pembayaran/{id}', [PembayaranController::class, 'updatePembayaran']); 

