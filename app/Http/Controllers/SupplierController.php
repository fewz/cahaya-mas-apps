<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ProductSupplier;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        // list view supplier
        $user = Auth::user();
        $list_supplier = Supplier::get();
        $data = [
            'user' => $user,
            'list_supplier' => $list_supplier
        ];
        return view("admin.supplier.index", $data);
    }

    public function add()
    {
        // add view supplier
        $user = Auth::user();
        $list_inventory = Inventory::get();
        $data = [
            'user' => $user,
            'list_inventory' => $list_inventory,
        ];
        return view("admin.supplier.add", $data);
    }

    public function do_add(Request $request)
    {
        // add supplier to database
        try {
            DB::beginTransaction();
            $list_produk = explode(',', $request->list_produk);
            $data = new Supplier();
            $total_sup =  count(Supplier::get()) + 1;
            if ($total_sup < 10) {
                $total_sup = '000' . $total_sup;
            } else if ($total_sup < 100) {
                $total_sup = '00' . $total_sup;
            } else if ($total_sup < 1000) {
                $total_sup = '0' . $total_sup;
            }
            $data->code = 'S' . $total_sup;
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->save();
            if (is_array($list_produk)) {
                foreach ($list_produk as $id_produk) {
                    ProductSupplier::add_product_supplier($id_produk, $data->id);
                }
            }
            DB::commit();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_supplier");
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

    public function edit($id)
    {
        // edit view supplier
        $user = Auth::user();
        $list_inventory = Inventory::get();
        $data_supplier = Supplier::find($id);
        $produk_supplier = ProductSupplier::where("product_supplier.id_supplier", $id)
            ->join("inventory", "inventory.id", "=", "product_supplier.id_product")
            ->select("product_supplier.*", "inventory.name")
            ->get();
        $data = [
            'user' => $user,
            'data_supplier' => $data_supplier,
            'data_produk_supplier' => $produk_supplier,
            'list_inventory' => $list_inventory
        ];
        return view("admin.supplier.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit supplier to database
        try {
            DB::beginTransaction();
            $list_produk = explode(',', $request->list_produk);
            $data = Supplier::where("id", $id)->first();
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->save();

            ProductSupplier::where("id_supplier", $id)->delete();
            if (is_array($list_produk)) {
                foreach ($list_produk as $id_produk) {
                    ProductSupplier::add_product_supplier($id_produk, $id);
                }
            }
            DB::commit();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_supplier");
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
        // delete supplier from database
        try {
            Supplier::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_supplier");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function get_product(Request $request)
    {
        $data = ProductSupplier::where("id_supplier", $request->id)
            ->join('inventory', 'inventory.id', '=', 'product_supplier.id_product')
            ->select('product_supplier.*', 'inventory.name as product_name', 'inventory.code as product_code')
            ->get();
        return $this->createSuccessMessage($data);
    }

    public function get_available_unit(Request $request)
    {
        $data = Unit::where("id_inventory", $request->id)
            ->get();

        return $this->createSuccessMessage($data);
    }
}
