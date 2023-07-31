<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        // list view category
        $user = Auth::user();
        $list_category = CategoryInventory::get();
        $data = [
            'user' => $user,
            'list_category' => $list_category
        ];
        return view("admin.inventory.category.index", $data);
    }

    public function add()
    {
        // add view category
        $user = Auth::user();
        $data = [
            'user' => $user
        ];
        return view("admin.inventory.category.add", $data);
    }

    public function do_add(Request $request)
    {
        // add category to database
        try {
            $data = new CategoryInventory();
            $data->name = $request->name;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_category");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function edit($id)
    {
        // edit view category
        $user = Auth::user();
        $data_category = CategoryInventory::find($id);
        $data = [
            'user' => $user,
            'data_category' => $data_category
        ];
        return view("admin.inventory.category.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit category to database
        try {
            $data = CategoryInventory::where("id", $id)->first();
            $data->name = $request->name;
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_category");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function delete(Request $request)
    {
        // delete category from database
        try {
            CategoryInventory::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_category");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
