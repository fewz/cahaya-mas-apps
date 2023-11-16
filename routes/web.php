<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PurchaseOrder;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Transaction;
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

Route::prefix('customer')->middleware('customerCheck:user')->group(function () {
    Route::get('/pesanan_saya', [CustomerController::class, 'pesanan_saya'])->name('customer/pesanan_saya');
    Route::get('/detail_pesanan/{id}', [CustomerController::class, 'detail_pesanan'])->name('customer/detail_pesanan');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer/profile');
    Route::post('/edit_profile', [CustomerController::class, 'edit_profile'])->name('customer/edit_profile');
    Route::post('/change_pass', [CustomerController::class, 'change_pass'])->name('customer/change_pass');
    Route::post('/detail_pesanan/do_finish', [CustomerController::class, 'finish_pesanan'])->name('customer/detail_pesanan/do_finish');
    Route::post('/detail_pesanan/upload_bukti_transfer', [CustomerController::class, 'upload_bukti_transfer'])->name('customer/detail_pesanan/upload_bukti_transfer');
});

Route::prefix('admin')->middleware('auth', 'roleCheck:user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/master_user', [UserController::class, 'index'])->name('master_user');
    Route::get('/master_user/add', [UserController::class, 'add'])->name('master_user/add');
    Route::post('/master_user/do_add', [UserController::class, 'do_add'])->name('master_user/do_add');
    Route::get('/master_user/edit/{id}', [UserController::class, 'edit'])->name('master_user/edit');
    Route::post('/master_user/do_edit/{id}', [UserController::class, 'do_edit'])->name('master_user/do_edit');
    Route::post('/master_user/delete', [UserController::class, 'delete'])->name('master_user/delete');

    Route::get('/master_role', [RoleController::class, 'index'])->name('master_role');
    Route::get('/master_role/add', [RoleController::class, 'add'])->name('master_role/add');
    Route::post('/master_role/do_add', [RoleController::class, 'do_add'])->name('master_role/do_add');
    Route::get('/master_role/edit/{id}', [RoleController::class, 'edit'])->name('master_role/edit');
    Route::post('/master_role/do_edit/{id}', [RoleController::class, 'do_edit'])->name('master_role/do_edit');
    Route::post('/master_role/delete', [RoleController::class, 'delete'])->name('master_role/delete');

    Route::get('/master_customer', [CustomerController::class, 'index'])->name('master_customer');
    Route::get('/master_customer/add', [CustomerController::class, 'add'])->name('master_customer/add');
    Route::post('/master_customer/do_add', [CustomerController::class, 'do_add'])->name('master_customer/do_add');
    Route::get('/master_customer/edit/{id}', [CustomerController::class, 'edit'])->name('master_customer/edit');
    Route::post('/master_customer/do_edit/{id}', [CustomerController::class, 'do_edit'])->name('master_customer/do_edit');
    Route::post('/master_customer/delete', [CustomerController::class, 'delete'])->name('master_customer/delete');

    Route::get('/master_supplier', [SupplierController::class, 'index'])->name('master_supplier');
    Route::get('/master_supplier/add', [SupplierController::class, 'add'])->name('master_supplier/add');
    Route::post('/master_supplier/do_add', [SupplierController::class, 'do_add'])->name('master_supplier/do_add');
    Route::get('/master_supplier/edit/{id}', [SupplierController::class, 'edit'])->name('master_supplier/edit');
    Route::post('/master_supplier/do_edit/{id}', [SupplierController::class, 'do_edit'])->name('master_supplier/do_edit');
    Route::post('/master_supplier/delete', [SupplierController::class, 'delete'])->name('master_supplier/delete');

    Route::get('/master_inventory', [InventoryController::class, 'index'])->name('master_inventory');
    Route::get('/master_inventory/add', [InventoryController::class, 'add'])->name('master_inventory/add');
    Route::post('/master_inventory/do_add', [InventoryController::class, 'do_add'])->name('master_inventory/do_add');
    Route::get('/master_inventory/edit/{id}', [InventoryController::class, 'edit'])->name('master_inventory/edit');
    Route::post('/master_inventory/do_edit/{id}', [InventoryController::class, 'do_edit'])->name('master_inventory/do_edit');
    Route::post('/master_inventory/delete', [InventoryController::class, 'delete'])->name('master_inventory/delete');
    Route::get('/master_inventory/view_stok/{id}', [InventoryController::class, 'view_stok'])->name('master_inventory/view_stok');
    Route::post('/master_inventory/edit_stok', [InventoryController::class, 'edit_stok'])->name('master_inventory/edit_stok');

    Route::get('/master_category', [CategoryController::class, 'index'])->name('master_category');
    Route::get('/master_category/add', [CategoryController::class, 'add'])->name('master_category/add');
    Route::post('/master_category/do_add', [CategoryController::class, 'do_add'])->name('master_category/do_add');
    Route::get('/master_category/edit/{id}', [CategoryController::class, 'edit'])->name('master_category/edit');
    Route::post('/master_category/do_edit/{id}', [CategoryController::class, 'do_edit'])->name('master_category/do_edit');
    Route::post('/master_category/delete', [CategoryController::class, 'delete'])->name('master_category/delete');

    Route::get('/purchase_order', [PurchaseOrder::class, 'index'])->name('purchase_order');
    Route::get('/purchase_order/add', [PurchaseOrder::class, 'add'])->name('purchase_order/add');
    Route::post('/purchase_order/do_add', [PurchaseOrder::class, 'do_add'])->name('purchase_order/do_add');
    Route::get('/purchase_order/edit/{id}', [PurchaseOrder::class, 'edit'])->name('purchase_order/edit');
    Route::post('/purchase_order/do_edit/{id}', [PurchaseOrder::class, 'do_edit'])->name('purchase_order/do_edit');
    Route::post('/purchase_order/delete', [PurchaseOrder::class, 'delete'])->name('purchase_order/delete');
    Route::get('/purchase_order/finish/{id}', [PurchaseOrder::class, 'finish'])->name('purchase_order/finish');
    Route::post('/purchase_order/do_finish/{id}', [PurchaseOrder::class, 'do_finish'])->name('purchase_order/do_finish');
    Route::get('/purchase_order/view/{id}', [PurchaseOrder::class, 'view'])->name('purchase_order/view');
    Route::post('/purchase_order/upload_bukti_transfer', [PurchaseOrder::class, 'upload_bukti_transfer'])->name('purchase_order/upload_bukti_transfer');

    Route::get('/master_diskon', [DiskonController::class, 'index'])->name('master_diskon');
    Route::get('/master_diskon/add', [DiskonController::class, 'add'])->name('master_diskon/add');
    Route::post('/master_diskon/do_add', [DiskonController::class, 'do_add'])->name('master_diskon/do_add');
    Route::get('/master_diskon/edit/{id}', [DiskonController::class, 'edit'])->name('master_diskon/edit');
    Route::post('/master_diskon/do_edit/{id}', [DiskonController::class, 'do_edit'])->name('master_diskon/do_edit');
    Route::post('/master_diskon/delete', [DiskonController::class, 'delete'])->name('master_diskon/delete');

    Route::get('/transaction', [Transaction::class, 'index'])->name('transaction');
    Route::get('/transaction/add', [Transaction::class, 'add'])->name('transaction/add');
    Route::post('/transaction/do_add', [Transaction::class, 'do_add'])->name('transaction/do_add');
    Route::get('/transaction/edit/{id}', [Transaction::class, 'edit'])->name('transaction/edit');
    Route::get('/transaction/view/{id}', [Transaction::class, 'view'])->name('transaction/view');
    Route::post('/transaction/do_edit/{id}', [Transaction::class, 'do_edit'])->name('transaction/do_edit');
    Route::post('/transaction/delete', [Transaction::class, 'delete'])->name('transaction/delete');
    Route::get('/transaction/invoice/{id}', [Transaction::class, 'invoice'])->name('transaction/invoice');
    Route::post('/transaction/update_status/', [Transaction::class, 'change_status'])->name('transaction/update_status');

    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman');
    Route::get('/pengiriman/add', [PengirimanController::class, 'add'])->name('pengiriman/add');
    Route::post('/pengiriman/do_add', [PengirimanController::class, 'do_add'])->name('pengiriman/do_add');
    Route::get('/pengiriman/view/{id}', [PengirimanController::class, 'view'])->name('pengiriman/view');
    Route::get('/pengiriman/surat_jalan/{id}', [PengirimanController::class, 'surat_jalan'])->name('pengiriman/surat_jalan');
    Route::post('/pengiriman/do_kirim', [PengirimanController::class, 'do_kirim'])->name('pengiriman/do_kirim');
    Route::post('/pengiriman/do_finish', [PengirimanController::class, 'do_finish'])->name('pengiriman/do_finish');

    Route::get('/master_setting', [UserController::class, 'master_setting'])->name('master_setting');
    Route::post('/master_setting/edit', [UserController::class, 'edit_setting'])->name('master_setting/edit');
    
    Route::get('/stok_opname', [StockController::class, 'index'])->name('stok_opname');
    Route::get('/stok_opname/add', [StockController::class, 'add'])->name('stok_opname/add');
    Route::post('/stok_opname/do_add', [StockController::class, 'do_add'])->name('stok_opname/do_add');
    Route::post('/stok_opname/revisi', [StockController::class, 'revisi'])->name('stok_opname/revisi');
    Route::post('/stok_opname/delete', [StockController::class, 'delete'])->name('stok_opname/delete');

    Route::get('/laporan_barang', [LaporanController::class, 'laporan_barang'])->name('laporan_barang');
    Route::get('/laporan_penjualan', [LaporanController::class, 'laporan_penjualan'])->name('laporan_penjualan');
    Route::get('/laporan_pembelian', [LaporanController::class, 'laporan_pembelian'])->name('laporan_pembelian');


    Route::get('/test', [UserController::class, 'tests'])->name('test');
});


Route::post("/do_login", [LoginController::class, 'doLogin']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/no_access', [LoginController::class, 'no_access'])->name('no_access');
