<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Pricing;
use App\Models\Role;
use App\Models\TierCustomer;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PricingController extends Controller
{
    public function index()
    {
        // list view pricing
        $user = Auth::user();
        $list_pricing = DB::table('tier_pricing')
            ->join('inventory', 'inventory.id', '=', 'tier_pricing.id_inventory')
            ->join('unit', 'unit.id', '=', 'tier_pricing.id_unit')
            ->join('tier_customer', 'tier_customer.id', '=', 'tier_pricing.id_tier_customer')
            ->select('tier_pricing.*', 'inventory.name as inventory', 'unit.name as unit', 'tier_customer.name as tier_customer')
            ->get();
        $data = [
            'user' => $user,
            'list_pricing' => $list_pricing
        ];
        return view("admin.inventory.pricing.index", $data);
    }

    public function add()
    {
        // add view pricing
        $user = Auth::user();
        $list_inventory = Inventory::get();
        $list_unit = Unit::get();
        $list_tier_customer = TierCustomer::get();
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory,
            'list_unit' => $list_unit,
            'list_tier_customer' => $list_tier_customer
        ];
        return view("admin.inventory.pricing.add", $data);
    }

    public function do_add(Request $request)
    {
        // add pricing to database
        try {
            $data = new Pricing();
            $data->id_inventory = $request->id_inventory;
            $data->id_unit = $request->id_unit;
            $data->id_tier_customer = $request->id_tier_customer;
            $data->sell_price = $request->sell_price;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_pricing");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function edit($id)
    {
        // edit view pricing
        $user = Auth::user();
        $data_pricing = Pricing::find($id);
        $list_inventory = Inventory::get();
        $list_unit = Unit::get();
        $list_tier_customer = TierCustomer::get();
        $data = [
            'user' => $user,
            'data_pricing' => $data_pricing,
            'list_inventory' => $list_inventory,
            'list_unit' => $list_unit,
            'list_tier_customer' => $list_tier_customer
        ];
        return view("admin.inventory.pricing.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit pricing to database
        try {
            $data = Pricing::where("id", $id)->first();
            $data->id_inventory = $request->id_inventory;
            $data->id_unit = $request->id_unit;
            $data->id_tier_customer = $request->id_tier_customer;
            $data->sell_price = $request->sell_price;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_pricing");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function delete(Request $request)
    {
        // delete pricing
        try {
            Pricing::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_pricing");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
