<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DTransaction;
use App\Models\HeaderPurchaseOrder;
use App\Models\HTransaction;
use App\Models\LogTerimaBarang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
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

        $notif_piutang = HTransaction::where('payment_method', 'CREDIT')
            ->whereBetween(DB::raw('UNIX_TIMESTAMP(due_date)'), [$endDate->timestamp, $futureDate->timestamp])
            ->where('h_transaction.status', '<>', '1')
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->select('h_transaction.*', 'customer.full_name as name', 'customer.phone as phone', 'customer.address as address')
            ->get();

        $notif_hutang = HeaderPurchaseOrder::where('payment_method', 'CREDIT')
            ->whereBetween(DB::raw('UNIX_TIMESTAMP(due_date)'), [$endDate->timestamp, $futureDate->timestamp])
            ->join('supplier', 'supplier.id', 'h_purchase_order.id_supplier')
            ->where('h_purchase_order.lunas', '<>', '1')
            ->select('h_purchase_order.*', 'supplier.name as name', 'supplier.phone as phone', 'supplier.address as address')
            ->get();
        $notif = [
            'hutang' => $notif_hutang,
            'piutang' => $notif_piutang
        ];
        Session::put('notif', $notif);

        $kadaluarsa = LogTerimaBarang::whereBetween('exp_date', [$endDate, $futureDate])
            ->join('inventory', 'inventory.id', 'log_terima_barang.id_inventory')
            ->join('unit', 'unit.id', 'log_terima_barang.id_unit')
            ->select('log_terima_barang.*', 'inventory.name as inventory', 'unit.name as unit', 'inventory.code as code')
            ->get();

        $laris = DTransaction::selectRaw('d_transaction.id_unit, SUM(d_transaction.qty) as total_qty,
        inventory.name as inventory, inventory.code as code, unit.name as unit')
            ->join('inventory', 'inventory.id', '=', 'd_transaction.id_inventory')
            ->join('unit', 'unit.id', '=', 'd_transaction.id_unit')
            ->groupBy('d_transaction.id_unit', 'inventory.name', 'inventory.code', 'unit.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $data_kadaluarsa = [];
        foreach ($kadaluarsa as $dt) {
            $total_terjual = DTransaction::get_total_terjual($dt->id_unit);
            $qty = $dt->qty - $total_terjual;
            if ($qty > 0) {
                $dt->qty = $qty;
                array_push($data_kadaluarsa, $dt);
            }
        }
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
            'kadaluarsa' => $data_kadaluarsa,
            'laris' => $laris
        ];
        return view("admin.dashboard", $data);
    }

    public function notif($filter = '')
    {
        $endDate = Carbon::now(); // End date is today
        $futureDate = Carbon::now()->addDays(7); // Start date is 6 days ago
        $notif_piutang = HTransaction::where('payment_method', 'CREDIT')
            ->whereBetween(DB::raw('UNIX_TIMESTAMP(due_date)'), [$endDate->timestamp, $futureDate->timestamp])
            ->where('h_transaction.status', '<>', '1')
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->select('h_transaction.*', 'customer.full_name as name', 'customer.phone as phone', 'customer.address as address')
            ->get();

        $notif_hutang = HeaderPurchaseOrder::where('payment_method', 'CREDIT')
            ->whereBetween(DB::raw('UNIX_TIMESTAMP(due_date)'), [$endDate->timestamp, $futureDate->timestamp])
            ->join('supplier', 'supplier.id', 'h_purchase_order.id_supplier')
            ->where('h_purchase_order.lunas', '<>', '1')
            ->select('h_purchase_order.*', 'supplier.name as name', 'supplier.phone as phone', 'supplier.address as address')
            ->get();

        $notif = [];
        foreach ($notif_piutang as $dt) {
            $dt->type = 'Piutang';
            array_push($notif, $dt);
        }
        foreach ($notif_hutang as $dt) {
            $dt->type = "Hutang";
            array_push($notif, $dt);
        }

        $a = [
            'hutang' => $notif_hutang,
            'piutang' => $notif_piutang
        ];
        Session::put('notif', $a);
        $user = Auth::user();
        $data = [
            'user' => $user,
            'notif' => $notif,
            'filter' => $filter
        ];
        return view("admin.notif", $data);
    }
}
