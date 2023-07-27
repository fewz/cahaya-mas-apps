<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryInventory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        // list view inventory
        $user = Auth::user();
        $list_inventory = DB::table('inventory')
            ->join('category_inventory', 'category_inventory.id', '=', 'inventory.id_category')
            ->select('inventory.*', 'category_inventory.name as category')
            ->get();
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory
        ];
        return view("admin.inventory.index", $data);
    }

    public function add()
    {
        // add view inventory
        $user = Auth::user();
        $list_category = CategoryInventory::get();
        $data = [
            'user' => $user,
            'list_category' => $list_category
        ];
        return view("admin.inventory.add", $data);
    }

    public function do_add(Request $request)
    {
        // add inventory to database
        try {
            $data = new Inventory();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->price_buy = $request->price_buy;
            $data->price_sell = $request->price_sell;
            $data->id_category = $request->id_category;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_inventory");
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
        // edit view inventory
        $user = Auth::user();
        $data_inventory = Inventory::find($id);
        $list_category = CategoryInventory::get();
        $data = [
            'user' => $user,
            'data_inventory' => $data_inventory,
            'list_category' => $list_category
        ];
        return view("admin.inventory.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit inventory to database
        try {
            $data = Inventory::where("id", $id)->first();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->price_buy = $request->price_buy;
            $data->price_sell = $request->price_sell;
            $data->id_category = $request->id_category;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_inventory");
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
            Inventory::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_inventory");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
