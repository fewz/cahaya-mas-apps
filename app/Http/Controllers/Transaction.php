<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DTransaction;
use App\Models\HTransaction;
use App\Models\Inventory;
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
            $data = new HTransaction();
            $data->order_number = $request->order_number;
            $data->id_cashier = $user->id;
            $data->created_date = $request->created_date;
            $data->id_customer = $request->id_customer;
            $data->total_diskon = $request->total_diskon;
            $data->grand_total = $request->grand_total;
            $data->payment_method = $request->payment_method;
            $data->diskon_poin = $request->diskon_poin;
            $data->transaction_type = $request->type;
            if ($request->payment_method === 'CASH') {
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

            foreach ($list_produk as $lp) {
                DTransaction::add_detail($data->id, $lp->id_product, $lp->id_unit, $lp->price, $lp->qty, $lp->subtotal, $lp->diskon);
                Unit::minus_stok($lp->id_unit, $lp->qty);
            }
            DB::commit();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/transaction");
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

        $data = [
            'user' => $user,
            'data_order' => $data_order,
            'data_product' => $data_product,
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
}
