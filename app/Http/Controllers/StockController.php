<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        // list view stock
        $user = Auth::user();
        $list_stock = DB::table('stock')
            ->join('inventory', 'inventory.id', '=', 'stock.id_inventory')
            ->join('unit', 'unit.id', '=', 'stock.id_unit')
            ->select('stock.*', 'inventory.name as inventory', 'unit.name as unit')
            ->get();
        $data = [
            'user' => $user,
            'list_stock' => $list_stock
        ];
        return view("admin.inventory.stock.index", $data);
    }

    public function add()
    {
        // add view stock
        $user = Auth::user();
        $list_inventory = Inventory::get();
        $list_unit = Unit::get();
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory,
            'list_unit' => $list_unit
        ];
        return view("admin.inventory.stock.add", $data);
    }

    public function do_add(Request $request)
    {
        // add stock to database
        try {
            $data = new Stock();
            $data->id_inventory = $request->id_inventory;
            $data->id_unit = $request->id_unit;
            $data->date_input = $request->date_input;
            $data->date_expired = $request->date_expired;
            $data->qty = $request->qty;
            $data->price_buy = $request->price_buy;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_stock");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function edit($id)
    {
        // edit view stock
        $user = Auth::user();
        $data_stock = Stock::find($id);
        $list_inventory = Inventory::get();
        $list_unit = Unit::get();
        $data = [
            'user' => $user,
            'data_stock' => $data_stock,
            'list_inventory' => $list_inventory,
            'list_unit' => $list_unit
        ];
        return view("admin.inventory.stock.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit stock to database
        try {
            $data = Stock::where("id", $id)->first();
            $data->id_inventory = $request->id_inventory;
            $data->id_unit = $request->id_unit;
            $data->date_input = $request->date_input;
            $data->date_expired = $request->date_expired;
            $data->qty = $request->qty;
            $data->price_buy = $request->price_buy;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_stock");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function delete(Request $request)
    {
        // delete stock from database
        try {
            Stock::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_stock");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
