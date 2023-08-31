<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\InventoryUnit;
use App\Models\Pricing;
use App\Models\Stock;
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
        // $stok = Unit::hitung_stok(30);
        // echo $stok;
        $list_inventory = DB::table('inventory')
            ->join('category_inventory', 'category_inventory.id', '=', 'inventory.id_category')
            ->select('inventory.*', 'category_inventory.name as category')
            ->get();

        foreach ($list_inventory as $inventory) {
            $stok = Unit::hitung_stok($inventory->id);
            $harga = Pricing::get_harga_general_list_inventory($inventory->id);
            $inventory->stok = $stok;
            $inventory->list_harga = $harga;
        }
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

            $index = 0;
            foreach ($pricing as $key => $value) {
                if ($index === 0) {
                    $id_unit = Unit::add_unit($data->id, $request->satuan_terkecil, NULL);
                } else {
                    $id_unit = Unit::add_unit($data->id, $key, $value->refunit[0]);
                }
                foreach ($value as $keyVal => $val) {
                    if ($keyVal !== 'refunit') {
                        Pricing::add_pricing($data->id, $id_unit, $keyVal, $val[0]);
                    }
                }
                $index++;
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
            ->orderBy('unit.qty_reference', 'asc')
            ->get();

        $data = [
            'user' => $user,
            'data_inventory' => $data_inventory,
            'list_category' => $list_category,
            'list_unit' => $list_unit
        ];

        return view("admin.inventory.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit inventory to database
        try {
            DB::beginTransaction();
            $pricing = json_decode($request->pricing);
            $list_units = json_decode($request->list_units);
            $data = Inventory::where("id", $id)->first();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->id_category = $request->id_category;
            $data->save();

            $oldUnit = Unit::where("id_inventory", $id)->get();

            foreach ($oldUnit as $old) {
                //delete unnecessary unit
                $isDeleted = true;
                foreach ($list_units as $unit) {
                    if ($old->id == $unit->id) {
                        $isDeleted = false;
                    }
                }

                if ($isDeleted) {
                    Unit::where('id', $old->id)->delete();
                }
            }

            foreach ($list_units as $unit) {
                //edit unit
                $isUpdate = false;
                foreach ($oldUnit as $old) {
                    if ($old->id == $unit->id) {
                        Unit::edit_unit($unit->id, $id, $unit->name, $unit->refunit);
                        $isUpdate = true;
                    }
                }
                if (!$isUpdate) {
                    $pricing->{$unit->name}->id->value = Unit::add_unit($id, $unit->name, $unit->refunit);
                }
            }

            // delete old pricing
            Pricing::where("id_inventory", $request->id)->delete();

            foreach ($pricing as $value) {
                // add new pricing
                $id_unit = $value->id->value;
                foreach ($value as $keyVal => $val) {
                    if ($keyVal === 'refunit' || $keyVal === 'id') {
                        continue;
                    }
                    Pricing::add_pricing($id, $id_unit, $keyVal, $val->value);
                }
            }

            DB::commit();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_inventory");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            DB::rollBack();
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
