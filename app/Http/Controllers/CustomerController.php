<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DTransaction;
use App\Models\HTransaction;
use App\Models\TierCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        // list view customer
        $user = Auth::user();
        $list_customer = Customer::get();
        $data = [
            'user' => $user,
            'list_customer' => $list_customer
        ];
        return view("admin.customer.index", $data);
    }

    public function add()
    {
        // add view customer
        $user = Auth::user();
        $data = [
            'user' => $user
        ];
        return view("admin.customer.add", $data);
    }

    public function do_add(Request $request)
    {
        // add customer to database
        try {
            $data = new Customer();
            $total_customer =  count(Customer::get());
            if ($total_customer < 10) {
                $total_customer = '000' . $total_customer;
            } else if ($total_customer < 100) {
                $total_customer = '00' . $total_customer;
            } else if ($total_customer < 1000) {
                $total_customer = '0' . $total_customer;
            }
            $data->code = 'C' . $total_customer;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->full_name = $request->full_name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->tier_customer = $request->tier_customer;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_customer");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            if (str_contains($ex->getMessage(), 'Duplicate entry')) {
                CommonHelper::showAlert(
                    "Failed",
                    'Code ' . $request->code . ' already used',
                    "error",
                    "back"
                );
            } else {
                CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
            }
        }
    }

    public function edit($id)
    {
        // edit view customer
        $user = Auth::user();
        $data_customer = Customer::find($id);
        $data = [
            'user' => $user,
            'data_customer' => $data_customer
        ];
        return view("admin.customer.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit customer to database
        try {
            $data = Customer::where("id", $id)->first();
            $data->email = $request->email;
            if ($request->password) {
                $data->password = Hash::make($request->password);
            }
            $data->full_name = $request->full_name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->tier_customer = $request->tier_customer;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_customer");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            if (str_contains($ex->getMessage(), 'Duplicate entry')) {
                CommonHelper::showAlert(
                    "Failed",
                    'Code ' . $request->code . ' already used',
                    "error",
                    "back"
                );
            } else {
                CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
            }
        }
    }

    public function delete(Request $request)
    {
        // delete customer from database
        try {
            Customer::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_customer");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function pesanan_saya()
    {
        $customer = Customer::get_login_customer();
        $transaksi = HTransaction::where('id_customer', $customer->id)->get();
        $data = [
            'user' => $customer,
            'transaksi' => $transaksi
        ];
        return view("customer.pesanan_saya", $data);
    }

    public function detail_pesanan($id)
    {
        $customer = Customer::get_login_customer();
        $data_order = HTransaction::find($id);
        $data_product = DTransaction::where("d_transaction.id_h_transaction", $id)
            ->join("inventory", "inventory.id", "=", "d_transaction.id_inventory")
            ->join("unit", "unit.id", "=", "d_transaction.id_unit")
            ->select("d_transaction.*", "inventory.name as product_name", "unit.name as unit_name", "inventory.code as product_code")
            ->get();

        $data = [
            'user' => $customer,
            'data_order' => $data_order,
            'data_product' => $data_product
        ];
        return view("customer.detail_pesanan", $data);
    }

    public function finish_pesanan(Request $request)
    {

        $id = $request->id;
        $transaksi = HTransaction::find($id);
        if ($transaksi->payment_method === 'CASH') {
            $transaksi->status = 1;
            Customer::add_poin($transaksi->id_customer, $transaksi->grand_total);
        } else {
            $transaksi->status = 2;
        }
        $transaksi->save();

        CommonHelper::showAlert("Success", "Barang telah diterima", "success", "/customer/pesanan_saya");
    }

    public function upload_bukti_transfer(Request $request)
    {
        $file = $request->file('file');

        // print_r($file);
        $file->move('bukti_transfer_transaction', $request->id);
        $data = HTransaction::where("id", $request->id)->first();
        $data->status = 7;
        $data->finish_date = today();
        $data->save();
        CommonHelper::showAlert("Success", "Upload Bukti Transfer Berhasil", "success", "/customer/pesanan_saya");
    }

    public function profile()
    {

        $customer = Customer::get_login_customer();
        $data = [
            'user' => $customer
        ];
        return view("customer.profile", $data);
    }

    public function edit_profile(Request $request)
    {
        $customer = Customer::get_login_customer();

        $data = Customer::find($customer->id);
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->save();

        Session::put('customer_data', $data);
        CommonHelper::showAlert("Success", "Update Alamat & Telp Berhasil", "success", "/customer/profile");
    }

    public function change_pass(Request $request)
    {
        $customer = Customer::get_login_customer();

        $ada = Customer::check_user($customer->email, $request->old_pass);
        if ($ada === null) {
            CommonHelper::showAlert("Fail", "Password lama salah", "error", "/customer/profile");
        } else {
            $data = Customer::find($customer->id);
            $data->password = Hash::make($request->password);
            $data->save();

            Session::put('customer_data', $data);
            CommonHelper::showAlert("Success", "Password berhasil diganti", "success", "/customer/profile");
        }
    }
}
