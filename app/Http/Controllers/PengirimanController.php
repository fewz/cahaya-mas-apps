<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DPengiriman;
use App\Models\DTransaction;
use App\Models\HPengiriman;
use App\Models\HTransaction;
use App\Models\Inventory;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class PengirimanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $list_pengiriman = HPengiriman::get();
        $data = [
            'user' => $user,
            'list_pengiriman' => $list_pengiriman
        ];
        return view("admin.pengiriman.index", $data);
    }

    public function add()
    {
        $user = Auth::user();
        $list_transaction = HTransaction::where('h_transaction.transaction_type', 'DELIVERY')
            ->where('h_transaction.status', 3)
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->join('users', 'users.id', 'h_transaction.id_cashier')
            ->select('h_transaction.*', 'customer.full_name as customer_name', 'customer.address as alamat', 'customer.phone as telp', 'users.username as cashier')
            ->get();
        $data = [
            'user' => $user,
            'list_transaction' => $list_transaction
        ];
        return view("admin.pengiriman.add", $data);
    }

    public function do_add(Request $request)
    {
        try {
            DB::beginTransaction();
            $list_transaksi = json_decode($request->transaksi);

            $total_delivery =  count(HPengiriman::get());
            $data = new HPengiriman();
            $data->status = 0;
            $data->delivery_date = $request->delivery_date;
            $data->driver = $request->driver;
            $data->code = 'DE' . date('dmy') . $total_delivery;
            $data->save();

            foreach ($list_transaksi as $t) {
                $detail = new DPengiriman();
                $detail->id_h_transaction = $t->id;
                $detail->id_h_pengiriman = $data->id;
                $detail->save();

                $transaksi = HTransaction::find($t->id);
                $transaksi->status = 4;
                $transaksi->id_h_pengiriman = $data->id;
                $transaksi->delivery_date = $request->delivery_date;
                $transaksi->save();
            }


            DB::commit();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/pengiriman");
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function view($id)
    {
        $user = Auth::user();
        $h_pengiriman = HPengiriman::where('id', $id)->first();
        $list_transaksi = DPengiriman::where('d_pengiriman.id_h_pengiriman', $id)
            ->join('h_transaction', 'h_transaction.id', 'd_pengiriman.id_h_transaction')
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->join('users', 'users.id', 'h_transaction.id_cashier')
            ->select('h_transaction.*', 'customer.full_name as customer_name', 'customer.address as alamat', 'customer.phone as telp', 'users.username as cashier')
            ->get();

        $barang_muat = [];
        foreach ($list_transaksi as $transaksi) {
            $detail = DTransaction::where('d_transaction.id_h_transaction', $transaksi->id)
                ->join('unit', 'unit.id', 'd_transaction.id_unit')
                ->join('inventory', 'inventory.id', 'd_transaction.id_inventory')
                ->select('d_transaction.*', 'unit.name as unit', 'inventory.name as inventory', 'inventory.code as code_inventory')
                ->get();

            foreach ($detail as $d) {
                $exist = false;
                foreach ($barang_muat as $b) {
                    if ($b->id_unit === $d->id_unit) {
                        $b->qty += $d->qty;
                        $exist = true;
                    }
                }
                if (!$exist) {
                    array_push($barang_muat, $d);
                }
            }
        }
        $data = [
            'user' => $user,
            'h_pengiriman' => $h_pengiriman,
            'list_transaksi' => $list_transaksi,
            'barang_muat' => $barang_muat,
        ];
        return view("admin.pengiriman.view", $data);
    }

    public function surat_jalan($id)
    {
        $user = Auth::user();
        $header_transaction = HTransaction::where('h_transaction.id', $id)
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->join('users', 'users.id', 'h_transaction.id_cashier')
            ->join('h_pengiriman', 'h_pengiriman.id', 'h_transaction.id_h_pengiriman')
            ->select('h_transaction.*', 'customer.full_name as customer_name', 'customer.address as alamat', 'customer.phone as telp', 'users.username as cashier', 'h_pengiriman.*')
            ->first();
        $detail_transaction = DTransaction::where('d_transaction.id_h_transaction', $id)
            ->join('inventory', 'inventory.id', 'd_transaction.id_inventory')
            ->join('unit', 'unit.id', 'd_transaction.id_unit')
            ->select('d_transaction.*', 'unit.name as unit', 'inventory.code as code_inventory', 'inventory.name as inventory')
            ->get();
        $data = [
            'user' => $user,
            'header_transaction' => $header_transaction,
            'detail_transaction' => $detail_transaction
        ];
        return view("admin.pengiriman.surat_jalan", $data);
    }

    public function do_kirim(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = HPengiriman::find($request->id);
            $data->status = 1;
            $data->save();

            $transaksi = HTransaction::where('id_h_pengiriman', $request->id)
                ->get();
            foreach ($transaksi as $t) {
                $t->status = 5;
                $t->save();
            }
            DB::commit();
            CommonHelper::showAlert("Success", "Pengiriman berjalan", "success", "/admin/pengiriman");
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function do_finish(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = HPengiriman::find($request->id);
            $data->status = 2;
            $data->save();

            $transaksi = HTransaction::where('id_h_pengiriman', $request->id)
                ->get();
            foreach ($transaksi as $t) {
                $t->status = 6;
                $t->save();
            }
            DB::commit();
            CommonHelper::showAlert("Success", "Pengiriman selesai", "success", "/admin/pengiriman");
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
