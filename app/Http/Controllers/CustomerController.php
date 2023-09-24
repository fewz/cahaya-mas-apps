<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\TierCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $data->code = $request->code;
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
            $data->code = $request->code;
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
}
