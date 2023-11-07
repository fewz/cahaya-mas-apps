<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\HeaderPurchaseOrder;
use App\Models\HTransaction;
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
        $graph_sales = HTransaction::whereBetween('created_date', [$startDate, $endDate])
            ->selectRaw('DATE(created_date) as date, DAYNAME(created_date) as day_name, SUM(grand_total) as total_sales')
            ->groupBy('date', 'day_name')
            ->get();

        $total_transaksi = HTransaction::whereBetween('created_date', [$startDate, $endDate])
            ->selectRaw('DATE(created_date) as date, DAYNAME(created_date) as day_name, COUNT(*) as total_transaksi')
            ->groupBy('date', 'day_name')
            ->get();
        $data = [
            'user' => $user,
            'transaksi_bulan_ini' => $transaksi_bulan_ini,
            'transaksi_butuh_dikirim' => $transaksi_butuh_dikirim,
            'total_customer' => $total_customer,
            'total_po' => $total_po,
            'graph_sales' => $graph_sales,
            'total_transaksi' => $total_transaksi
        ];
        return view("admin.dashboard", $data);
    }
}
