<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\InventoryUnit;
use App\Models\Pricing;
use App\Models\Unit;
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
            $pricing = json_decode($request->pricing);
            $data = new Inventory();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->id_category = $request->id_category;
            $data->save();

            Unit::add_unit($data->id, $request->satuan_terkecil, NULL);
            foreach ($pricing as $key => $value) {
                $id_unit = Unit::add_unit($data->id, $key, $value->refunit[0]);
                foreach ($value as $keyVal => $val) {
                    if ($keyVal !== 'refunit') {
                        Pricing::add_pricing($data->id, $id_unit, $keyVal, $val[0]);
                    }
                }
            }

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
        $list_unit = Unit::where("unit.id_inventory", $id)
            ->leftJoin('tier_pricing', 'tier_pricing.id_unit', '=', 'unit.id')
            ->orderBy('unit.id', 'asc')
            ->get();

        $data = [
            'user' => $user,
            'data_inventory' => $data_inventory,
            'list_category' => $list_category,
            'list_unit' => $list_unit
        ];

        // print_r($list_unit);

        return view("admin.inventory.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit inventory to database
        try {
            $pricing = json_decode($request->pricing);
            $data = Inventory::where("id", $id)->first();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->id_category = $request->id_category;
            $data->save();

            Unit::where("id_inventory", $request->id)->delete();
            Pricing::where("id_inventory", $request->id)->delete();

            Unit::add_unit($data->id, $request->satuan_terkecil, NULL);
            foreach ($pricing as $key => $value) {
                $id_unit = Unit::add_unit($data->id, $key, $value->refunit[0]);
                foreach ($value as $keyVal => $val) {
                    if ($keyVal !== 'refunit') {
                        Pricing::add_pricing($data->id, $id_unit, $keyVal, $val[0]);
                    }
                }
            }

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
            // delete inventory_unit first
            InventoryUnit::where("id_inventory", $request->id)->delete();
            Inventory::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_inventory");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
