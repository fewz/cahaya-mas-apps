<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\HeaderPurchaseOrder;
use App\Models\HTransaction;
use App\Models\LogTerimaBarang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transaksi_bulan_ini = HTransaction::whereBetween('created_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();
        $transaksi_butuh_dikirim = HTransaction::where('status', 3)->count();
        $total_customer = Customer::count();
        $total_po = HeaderPurchaseOrder::count();


        $endDate = Carbon::now(); // End date is today
        $startDate = Carbon::now()->subDays(6); // Start date is 6 days ago
        $futureDate = Carbon::now()->addDays(7); // Start date is 6 days ago
        $graph_sales = HTransaction::whereBetween('created_date', [$startDate, $endDate])
            ->selectRaw('created_date as date, DAYNAME(created_date) as day_name, SUM(grand_total) as total_sales')
            ->groupBy('date', 'day_name')
            ->get();


        $total_transaksi = HTransaction::whereBetween('created_date', [$startDate, $endDate])
            ->selectRaw('DATE(created_date) as date, DAYNAME(created_date) as day_name, COUNT(*) as total_transaksi')
            ->groupBy('date', 'day_name')
            ->get();

        $notif_piutang = HTransaction::whereBetween('due_date', [$endDate, $futureDate])
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->where('h_transaction.status', '<>', '1')
            ->select('h_transaction.*', 'customer.full_name as name', 'customer.phone as phone', 'customer.address as address')
            ->get();
        $notif_hutang = HeaderPurchaseOrder::whereBetween('due_date', [$endDate, $futureDate])
            ->join('supplier', 'supplier.id', 'h_purchase_order.id_supplier')
            ->where('h_purchase_order.lunas', '<>', '1')
            ->select('h_purchase_order.*', 'supplier.name as name', 'supplier.phone as phone', 'supplier.address as address')
            ->get();

        $kadaluarsa = LogTerimaBarang::whereBetween('exp_date', [$endDate, $futureDate])
            ->join('inventory', 'inventory.id', 'log_terima_barang.id_inventory')
            ->join('unit', 'unit.id', 'log_terima_barang.id_unit')
            ->select('log_terima_barang.*', 'inventory.name as inventory', 'unit.name as unit', 'inventory.code as code')
            ->get();
        $data = [
            'user' => $user,
            'transaksi_bulan_ini' => $transaksi_bulan_ini,
            'transaksi_butuh_dikirim' => $transaksi_butuh_dikirim,
            'total_customer' => $total_customer,
            'total_po' => $total_po,
            'graph_sales' => $graph_sales,
            'notif_piutang' => $notif_piutang,
            'notif_hutang' => $notif_hutang,
            'total_transaksi' => $total_transaksi,
            'kadaluarsa' => $kadaluarsa
        ];
        return view("admin.dashboard", $data);
    }
}
