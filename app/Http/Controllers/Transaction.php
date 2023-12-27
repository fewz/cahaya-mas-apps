<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DTransaction;
use App\Models\HTransaction;
use App\Models\Inventory;
use App\Models\ReturTransaction;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class Transaction extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->id_role === 1) {
            $list_transaction = HTransaction::join('customer', 'customer.id', 'h_transaction.id_customer')
                ->join('users', 'users.id', 'h_transaction.id_cashier')
                ->select('h_transaction.*', 'users.username as cashier_name', 'customer.full_name as customer_name')
                ->get();
        } else {
            $list_transaction = HTransaction::get_list_transaction($user->id);
        }
        $data = [
            'user' => $user,
            'list_transaction' => $list_transaction
        ];
        return view("admin.transaction.index", $data);
    }

    public function add()
    {
        $user = Auth::user();
        $list_inventory = Inventory::get();
        $list_customer = Customer::get();
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory,
            'list_customer' => $list_customer
        ];
        return view("admin.transaction.add", $data);
    }

    public function do_add(Request $request)
    {
        try {
            DB::beginTransaction();
            $list_produk = json_decode($request->list_produk);
            $user = Auth::user();
            $total_transaction =  count(HTransaction::get());
            $data = new HTransaction();
            $data->order_number = 'TR' . date('dmy') . $total_transaction;
            $data->id_cashier = $user->id;
            $data->created_date = $request->created_date;
            $data->id_customer = $request->id_customer;
            $data->total_diskon = $request->total_diskon;
            $data->grand_total = $request->grand_total;
            $data->payment_method = $request->payment_method;
            $data->diskon_poin = $request->diskon_poin;

            Customer::min_poin($request->id_customer, $request->diskon_poin);
            $data->transaction_type = $request->type;
            if ($request->payment_method === 'CASH' && $request->transaction_type !== 'DELIVERY') {
                $data->status = 1;
                Customer::add_poin($request->id_customer, $request->grand_total);
            } else {
                $data->status = 2;
                $data->due_date = $request->due_date;
            }
            if ($data->transaction_type === 'DELIVERY') {
                $data->status = 3;
            }
            $data->save();

            $total_net = 0;
            foreach ($list_produk as $lp) {
                $stok_akhir = Unit::minus_stok($lp->id_unit, $lp->qty);
                $net = DTransaction::add_detail($data->id, $lp->id_product, $lp->id_unit, $lp->price, $lp->qty, $lp->subtotal, $lp->diskon, $stok_akhir);
                $total_net += $net;
            }

            $data->netto = $total_net;
            $data->save();
            DB::commit();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/transaction/view/" . $data->id);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function view($id)
    {
        $user = Auth::user();
        $data_order = HTransaction::find($id);
        $data_product = DTransaction::where("d_transaction.id_h_transaction", $id)
            ->join("inventory", "inventory.id", "=", "d_transaction.id_inventory")
            ->join("unit", "unit.id", "=", "d_transaction.id_unit")
            ->select("d_transaction.*", "inventory.name as product_name", "unit.name as unit_name", "inventory.code as product_code")
            ->get();

        $data_customer = Customer::find($data_order->id_customer);

        $data_retur = ReturTransaction::where('retur_transaction.id_h_transaction', $data_order->id)
            ->join('d_transaction', "retur_transaction.id_d_transaction", 'd_transaction.id')
            ->join("inventory", "inventory.id", "=", "d_transaction.id_inventory")
            ->join("unit", "unit.id", "=", "d_transaction.id_unit")
            ->select("retur_transaction.*", "inventory.name as product_name", "unit.name as unit_name", "inventory.code as product_code")
            ->get();

        $data = [
            'user' => $user,
            'data_order' => $data_order,
            'data_product' => $data_product,
            'data_retur' => $data_retur,
            'data_customer' => $data_customer
        ];
        return view("admin.transaction.view", $data);
    }

    public function get_detail($id)
    {
        $data = new stdClass();
        $data->header = HTransaction::where('h_transaction.id', $id)
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->select('h_transaction.*', 'customer.full_name as customer', 'customer.address as address')
            ->first();
        $data->detail = DTransaction::where('d_transaction.id_h_transaction', $id)
            ->join('inventory', 'inventory.id', 'd_transaction.id_inventory')
            ->join('unit', 'unit.id', 'd_transaction.id_unit')
            ->select('d_transaction.*', 'inventory.name as product_name', 'inventory.code as product_code', 'unit.name as unit')
            ->get();

        return $this->createSuccessMessage($data);
    }

    public function invoice($id)
    {

        $user = Auth::user();
        $header_transaction = HTransaction::where('h_transaction.id', $id)
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->join('users', 'users.id', 'h_transaction.id_cashier')
            ->select('h_transaction.*', 'customer.full_name as customer_name', 'customer.poin as poin', 'customer.address as alamat', 'customer.phone as telp', 'users.username as cashier')
            ->first();
        // print_r($header_transaction);
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
        return view("admin.transaction.invoice", $data);
    }

    public function change_status(Request $request)
    {
        $data = HTransaction::find($request->id);
        $data->status = $request->status;
        if ($request->status == 1) {
            Customer::add_poin($data->id_customer, $data->grand_total);
        }
        $data->save();
        CommonHelper::showAlert("Success", "update data success", "success", "/admin/transaction");
    }

    public function get_tagihan_jatuh_tempo($selectedDate)
    {
        // echo $selectedDate;
        $data = HTransaction::where('h_transaction.due_date', $selectedDate)
            ->where('h_transaction.status', '<>', 1)
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->select('customer.full_name', 'customer.phone', 'customer.address', 'h_transaction.*')
            ->get();

        return $this->createSuccessMessage($data);
    }

    public function add_retur(Request $request)
    {
        try {
            DB::beginTransaction();
            $prd = json_decode($request->list_produk);
            foreach ($prd as $dt) {
                $data = new ReturTransaction();
                $data->id_d_transaction = $dt->id;
                $data->qty = $dt->qty;
                $data->note = $dt->note;
                $data->id_h_transaction = $request->id_h_po;
                $data->save();
                $d_trans = DTransaction::where('id', $dt->id)->first();
                Unit::add_stok($d_trans->id_unit, $dt->qty);
            }

            DB::commit();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_retur_transaksi/view/" . $request->id_h_po);
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            DB::rollBack();
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function view_retur($id)
    {
        $user = Auth::user();
        $list = ReturTransaction::where('retur_transaction.id_h_transaction', $id)
            ->join('h_transaction', 'retur_transaction.id_h_transaction', 'h_transaction.id')
            ->join('d_transaction', 'd_transaction.id', 'retur_transaction.id_d_transaction')
            ->join('inventory', 'inventory.id', 'd_transaction.id_inventory')
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->join('unit', 'unit.id', 'd_transaction.id_unit')
            ->select('retur_transaction.*', 'h_transaction.order_number as order_number', 'h_transaction.created_date as transaction_date', 'inventory.name as inventory', 'unit.name as unit', 'customer.full_name as customer')
            ->get();
        $data = [
            'user' => $user,
            'data' => $list
        ];
        return view("admin.transaction.viewretur", $data);
    }

    public function update_retur(Request $request)
    {
        $data = ReturTransaction::find($request->id);
        $d_trans = DTransaction::where('id', $data->id_d_transaction)->first();
        if ($request->status === 1) {
            Unit::minus_stok($d_trans->id_unit, $request->qty);
        }
        $data->status = $request->status;
        $data->save();
        CommonHelper::showAlert("Success", "Update data success", "success", "/admin/master_retur_transaksi/view/" . $request->id_h);
    }

    public function index_retur()
    {
        $user = Auth::user();
        $list_purchase = ReturTransaction::join('h_transaction', 'h_transaction.id', '=', 'retur_transaction.id_h_transaction')
            ->select('retur_transaction.*', 'h_transaction.order_number as order_number', 'h_transaction.created_date as transaction_date', DB::raw('count(retur_transaction.id_h_transaction) as total'))
            ->groupBy('retur_transaction.id_h_transaction')
            ->get();
        $data = [
            'user' => $user,
            'list_retur' => $list_purchase
        ];
        // print_r($data);
        return view("admin.transaction.retur", $data);
    }

    public function retur_add()
    {
        $user = Auth::user();
        $list_po = HTransaction::get();
        $data = [
            'user' => $user,
            'list_po' => $list_po
        ];
        return view("admin.transaction.addretur", $data);
    }
}
