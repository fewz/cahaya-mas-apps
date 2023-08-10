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
        $list_units = Unit::get();
        $data = [
            'user' => $user,
            'list_category' => $list_category,
            'list_units' => $list_units
        ];
        return view("admin.inventory.add", $data);
    }

    public function do_add(Request $request)
    {
        // add inventory to database
        try {
            $pricing = json_decode($request->pricing);
            $tier = [
                "general" => "1",
                "bronze" => "2",
                "silver" => "3",
                "gold" => "4",
            ];
            $data = new Inventory();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->id_category = $request->id_category;
            $data->save();

            if (isset($request->units)) {
                // add inventory unit to database
                foreach ($request->units as $unit_id) {
                    InventoryUnit::add_inventory_unit($data->id, $unit_id);
                }
            }
            if (count($pricing) > 0) {
                // add pricing to database
                foreach ($pricing as $p) {
                    Pricing::add_pricing($data->id, $p->id, $tier[$p->name], $p->value);
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
        $list_unit = unit::get();
        $inventory_unit = InventoryUnit::where('id_inventory', $id)->get('id_unit')->toArray();
        foreach ($inventory_unit as $key => $value) {
            // mapping id unit to show on view template
            $inventory_unit[$key] = $value['id_unit'];
        }

        $data = [
            'user' => $user,
            'data_inventory' => $data_inventory,
            'list_category' => $list_category,
            'list_unit' => $list_unit,
            'inventory_unit' => $inventory_unit
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
            $data->id_category = $request->id_category;
            $data->save();

            // delete previous existing inventory_unit database
            InventoryUnit::where("id_inventory", $request->id)->delete();

            if (isset($request->units)) {
                // add inventory_unit database
                foreach ($request->units as $id_unit) {
                    InventoryUnit::add_inventory_unit($id, $id_unit);
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
