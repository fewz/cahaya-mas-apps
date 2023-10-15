<?php

use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Transaction;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product_supplier', [SupplierController::class, 'get_product']);
Route::get('/available_unit', [SupplierController::class, 'get_available_unit']);

Route::get('/get_price_and_stock', [PricingController::class, 'get_price_and_stock']);

Route::get('/get_detail_transaction/{id}', [Transaction::class, 'get_detail']);

Route::get('/test', [UserController::class, 'test']);
