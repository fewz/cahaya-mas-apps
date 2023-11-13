<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DTransaction;
use App\Models\LogTerimaBarang;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LaporanController extends Controller
{
    public function laporan_barang()
    {
        // list view user
        $user = Auth::user();
        $log_terima_barang = LogTerimaBarang::join('inventory', 'inventory.id', 'log_terima_barang.id_inventory')
            ->join('unit', 'unit.id', 'log_terima_barang.id_unit')
            ->join('h_purchase_order', 'h_purchase_order.id', 'log_terima_barang.id_h_purchase_order')
            ->select('log_terima_barang.*', 'inventory.name as product_name', 'unit.name as unit_name', 'h_purchase_order.order_number as order_number', DB::raw('"Barang Masuk" as tipe'))
            ->get();

        $log_penjualan = DTransaction::join('inventory', 'inventory.id', 'd_transaction.id_inventory')
            ->join('unit', 'unit.id', 'd_transaction.id_unit')
            ->join('h_transaction', 'h_transaction.id', 'd_transaction.id_h_transaction')
            ->select('d_transaction.*', 'inventory.name as product_name', 'unit.name as unit_name', 'h_transaction.order_number as order_number', 'h_transaction.created_date as created_date', DB::raw('"Barang Keluar" as tipe'))
            ->get();

        $laporan_perlu_restok = Unit::join('inventory', 'inventory.id', 'unit.id_inventory')
            ->where('unit.stok', '<=', '10')
            ->select('unit.*', 'inventory.name as product_name')
            ->get();

        $laporan_stok = [];

        $laporan_kadaluarsa = LogTerimaBarang::join('inventory', 'inventory.id', 'log_terima_barang.id_inventory')
            ->join('unit', 'unit.id', 'log_terima_barang.id_unit')
            ->join('h_purchase_order', 'h_purchase_order.id', 'log_terima_barang.id_h_purchase_order')
            ->select('log_terima_barang.*', 'inventory.name as product_name', 'unit.name as unit_name', 'h_purchase_order.order_number as order_number', DB::raw('"Barang Masuk" as tipe'))
            ->whereDate('exp_date', '<=', Carbon::today()->toDateString())
            ->get();
        foreach ($log_terima_barang as $log) {
            array_push($laporan_stok, $log);
        }
        foreach ($log_penjualan as $log) {
            array_push($laporan_stok, $log);
        }
        $data = [
            'user' => $user,
            'laporan_stok' => $laporan_stok,
            'laporan_perlu_restok' => $laporan_perlu_restok,
            'laporan_kadaluarsa' => $laporan_kadaluarsa
        ];
        return view("admin.laporan.laporan_barang", $data);
    }
}
