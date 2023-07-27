<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        // list view supplier
        $user = Auth::user();
        $list_supplier = Supplier::get();
        $data = [
            'user' => $user,
            'list_supplier' => $list_supplier
        ];
        return view("admin.supplier.index", $data);
    }

    public function add()
    {
        // add view supplier
        $user = Auth::user();
        $data = [
            'user' => $user,
        ];
        return view("admin.supplier.add", $data);
    }

    public function do_add(Request $request)
    {
        // add supplier to database
        try {
            $data = new Supplier();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_supplier");
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
        // edit view supplier
        $user = Auth::user();
        $data_supplier = Supplier::find($id);
        $data = [
            'user' => $user,
            'data_supplier' => $data_supplier
        ];
        return view("admin.supplier.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit supplier to database
        try {
            $data = Supplier::where("id", $id)->first();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_supplier");
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
        // delete supplier from database
        try {
            Supplier::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_supplier");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
