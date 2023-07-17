<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/master_user', [UserController::class, 'index'])->name('master_user');
    Route::get('/master_user/add', [UserController::class, 'add'])->name('master_user/add');
    Route::post('/master_user/do_add', [UserController::class, 'do_add'])->name('master_user/do_add');
    Route::get('/master_user/edit/{id}', [UserController::class, 'edit'])->name('master_user/edit');
    Route::post('/master_user/do_edit/{id}', [UserController::class, 'do_edit'])->name('master_user/do_edit');
    Route::post('/master_user/delete', [UserController::class, 'delete'])->name('master_user/delete');

    Route::get('/master_role', [RoleController::class, 'index'])->name('master_role');
    Route::get('/master_customer', [CustomerController::class, 'index'])->name('master_customer');
    Route::get('/master_supplier', [SupplierController::class, 'index'])->name('master_supplier');
    Route::get('/master_inventory', [InventoryController::class, 'index'])->name('master_inventory');
});


Route::post("/do_login", [LoginController::class, 'doLogin']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
