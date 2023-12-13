<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\DTransaction;
use App\Models\HTransaction;
use App\Models\Inventory;
use App\Models\LogTerimaBarang;
use App\Models\Stock;
use App\Models\StokOpname;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        // list view stock
        $user = Auth::user();
        $list_stock = DB::table('stok_opname')
            ->join('unit', 'unit.id', '=', 'stok_opname.id_unit')
            ->join('inventory', 'inventory.id', 'unit.id_inventory')
            ->join('users', 'users.id', '=', 'stok_opname.id_user')
            ->select('stok_opname.*', 'users.username as checker', 'unit.name as unit', 'inventory.name as produk', 'unit.stok as stok_unit')
            ->get();
        $data = [
            'user' => $user,
            'list_stock' => $list_stock
        ];
        return view("admin.inventory.stock.index", $data);
    }

    public function add()
    {
        // add view stock
        $user = Auth::user();
        $list_inventory = Inventory::get();
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory
        ];
        return view("admin.inventory.stock.add", $data);
    }

    public function do_add(Request $request)
    {
        // add stock to database
        $user = Auth::user();
        try {
            $data = new StokOpname();
            $data->id_unit = $request->id_unit;
            $data->stok = $request->stok;
            $data->stok_gudang = $request->stok_gudang;
            $data->selisih = $request->selisih;
            $data->id_user = $user->id;
            $data->notes = $request->notes;
            $data->status = 0;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/penyesuaian_stok");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function revisi(Request $request)
    {
        $stok_opname = StokOpname::find($request->id_stok_opname);
        $stok_opname->status = 1;
        $stok_opname->stok_akhir = $request->stok_revisi;
        $stok_opname->save();

        $unit = Unit::find($stok_opname->id_unit);
        $unit->stok = $request->stok_revisi;
        $unit->save();
        CommonHelper::showAlert("Success", "update data success", "success", "/admin/penyesuaian_stok");
    }

    public function stok_opname(Request $request)
    {
        $date = now();
        if (isset($request->date)) {
            $date = $request->date;
        }

        // list view stock
        $user = Auth::user();

        // echo $date;
        $log = LogTerimaBarang::whereDate('created_date', '=', $date)
            ->join('unit', 'unit.id', 'log_terima_barang.id_unit')
            ->join('inventory', 'inventory.id', 'unit.id_inventory')
            ->select('inventory.name as inventory', 'unit.name as unit', 'log_terima_barang.qty as qty', 'log_terima_barang.created_date as created_date', 'log_terima_barang.stok_akhir as stok_akhir')
            ->get()
            ->map(function ($item) {
                $item['tipe'] = 'masuk';
                return $item;
            });
        $transaction = HTransaction::whereDate('h_transaction.created_date', '=', $date)
            ->join('d_transaction', 'd_transaction.id_h_transaction', 'h_transaction.id')
            ->join('unit', 'unit.id', 'd_transaction.id_unit')
            ->join('inventory', 'inventory.id', 'd_transaction.id_inventory')
            ->select('inventory.name as inventory', 'unit.name as unit', 'd_transaction.qty as qty', 'h_transaction.created_date as created_date', 'd_transaction.stok_akhir as stok_akhir')
            ->get()
            ->map(function ($item) {
                $item['tipe'] = 'keluar';
                return $item;
            });
        $stok = StokOpname::whereDate('stok_opname.created_date', '=', $date)
            ->join('unit', 'unit.id', 'stok_opname.id_unit')
            ->join('inventory', 'inventory.id', 'unit.id_inventory')
            ->select('inventory.name as inventory', 'unit.name as unit', 'stok_opname.selisih as qty', 'stok_opname.created_date as created_date', 'stok_opname.stok_akhir as stok_akhir')
            ->get()
            ->map(function ($item) {
                if ($item->qty < 0) {
                    $item['tipe'] = 'keluar';
                    $item['qty'] *= -1;
                } else {
                    $item['type'] = 'masuk';
                }
                return $item;
            });

        // Merge the collections
        $mergedCollection = $log->concat($transaction)->concat($stok);

        // Sort the merged collection by the created_date field
        $sortedCollection = $mergedCollection->sortBy('created_date');

        $data = [
            'user' => $user,
            'list_data' => $sortedCollection,
            'tgl' => $date
        ];
        return view("admin.inventory.stock.stok_opname", $data);
    }


    public function delete(Request $request)
    {
        // delete stock from database
        try {
            StokOpname::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/penyesuaian_stok");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
