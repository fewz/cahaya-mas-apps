<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Stock;
use App\Models\StokOpname;
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
        $list_stock = DB::table('stok_opname')
            ->join('unit', 'unit.id', '=', 'stok_opname.id_unit')
            ->join('inventory', 'inventory.id', 'unit.id_inventory')
            ->join('users', 'users.id', '=', 'stok_opname.id_user')
            ->select('stok_opname.*', 'users.username as checker', 'unit.name as unit', 'inventory.name as produk', 'unit.stok as stok_unit')
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
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory
        ];
        return view("admin.inventory.stock.add", $data);
    }

    public function do_add(Request $request)
    {
        // add stock to database
        $user = Auth::user();
        try {
            $data = new StokOpname();
            $data->id_unit = $request->id_unit;
            $data->stok = $request->stok;
            $data->stok_gudang = $request->stok_gudang;
            $data->selisih = $request->selisih;
            $data->id_user = $user->id;
            $data->notes = $request->notes;
            $data->status = 0;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/stok_opname");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function revisi(Request $request)
    {
        $stok_opname = StokOpname::find($request->id_stok_opname);
        $stok_opname->status = 1;
        $stok_opname->save();

        $unit = Unit::find($stok_opname->id_unit);
        $unit->stok = $request->stok_revisi;
        $unit->save();
        CommonHelper::showAlert("Success", "update data success", "success", "/admin/stok_opname");
    }

    // public function edit($id)
    // {
    //     // edit view stock
    //     $user = Auth::user();
    //     $data_stock = Stock::find($id);
    //     $list_inventory = Inventory::get();
    //     $list_unit = Unit::get();
    //     $data = [
    //         'user' => $user,
    //         'data_stock' => $data_stock,
    //         'list_inventory' => $list_inventory,
    //         'list_unit' => $list_unit
    //     ];
    //     return view("admin.inventory.stock.edit", $data);
    // }

    // public function do_edit($id, Request $request)
    // {
    //     // edit stock to database
    //     try {
    //         $data = Stock::where("id", $id)->first();
    //         $data->id_inventory = $request->id_inventory;
    //         $data->id_unit = $request->id_unit;
    //         $data->date_input = $request->date_input;
    //         $data->date_expired = $request->date_expired;
    //         $data->qty = $request->qty;
    //         $data->price_buy = $request->price_buy;
    //         $data->save();
    //         CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_stock");
    //     } catch (\Illuminate\Database\QueryException $ex) {
    //         // catch error
    //         CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
    //     }
    // }

    public function delete(Request $request)
    {
        // delete stock from database
        try {
            StokOpname::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/stok_opname");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
