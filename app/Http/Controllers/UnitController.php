<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        // list view unit
        $user = Auth::user();
        $list_unit = DB::table('unit')
            ->leftJoin('unit as u', 'u.id', '=', 'unit.id_reference')
            ->select('unit.*', 'u.name as reference')
            ->get();
        $data = [
            'user' => $user,
            'list_unit' => $list_unit
        ];
        return view("admin.inventory.unit.index", $data);
    }

    public function add()
    {
        // add view unit
        $user = Auth::user();
        $list_unit = Unit::get();
        $data = [
            'user' => $user,
            'list_unit' => $list_unit
        ];
        return view("admin.inventory.unit.add", $data);
    }

    public function do_add(Request $request)
    {
        // add unit to database
        try {
            $data = new Unit();
            $data->name = $request->name;
            $data->id_reference = $request->id_reference;
            $data->qty_reference = $request->qty_reference;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_unit");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function edit($id)
    {
        // edit view unit
        $user = Auth::user();
        $data_unit = Unit::find($id);
        $list_unit = Unit::get();
        $data = [
            'user' => $user,
            'data_unit' => $data_unit,
            'list_unit' => $list_unit
        ];
        return view("admin.inventory.unit.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit unit to database
        try {
            $data = Unit::where("id", $id)->first();
            $data->name = $request->name;
            $data->id_reference = $request->id_reference;
            $data->qty_reference = $request->qty_reference;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_unit");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function delete(Request $request)
    {
        // delete unit from database
        try {
            Unit::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_unit");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
