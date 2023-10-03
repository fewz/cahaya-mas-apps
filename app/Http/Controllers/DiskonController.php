<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Diskon;
use App\Models\Inventory;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiskonController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data_diskon = Diskon::join('inventory', 'diskon.id_inventory', 'inventory.id')
            ->join('unit', 'unit.id', 'diskon.id_unit')
            ->select('diskon.*', 'inventory.name as product_name', 'unit.name as unit')
            ->get();
        $data = [
            'user' => $user,
            'data_diskon' => $data_diskon
        ];
        return view("admin.diskon.index", $data);
    }

    public function add()
    {
        $user = Auth::user();
        $list_inventory = Inventory::get();
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory
        ];
        return view("admin.diskon.add", $data);
    }

    public function do_add(Request $request)
    {
        // add customer to database
        try {
            $data = new Diskon();
            $data->id_inventory = $request->id_inventory;
            $data->minimal = $request->minimal;
            $data->potongan = $request->potongan;
            $data->id_unit = $request->id_unit;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_diskon");
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
        $user = Auth::user();
        $data_diskon = Diskon::find($id);
        $list_inventory = Inventory::get();
        $list_unit = Unit::where('id_inventory', $data_diskon->id_inventory)->get();
        $data = [
            'user' => $user,
            'data_diskon' => $data_diskon,
            'list_inventory' => $list_inventory,
            'list_unit' => $list_unit
        ];
        return view("admin.diskon.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        try {
            $data = Diskon::where("id", $id)->first();
            $data->id_inventory = $request->id_inventory;
            $data->minimal = $request->minimal;
            $data->potongan = $request->potongan;
            $data->id_unit = $request->id_unit;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_diskon");
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
            Diskon::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_diskon");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
