<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryInventory;
use App\Models\DetailPurchaseOrder;
use App\Models\HeaderPurchaseOrder;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrder extends Controller
{
    public function index()
    {
        // list view category
        $user = Auth::user();
        $list_purchase = HeaderPurchaseOrder::join('supplier', 'h_purchase_order.id_supplier', '=', 'supplier.id')
            ->select('h_purchase_order.*', 'supplier.name as supplier_name')
            ->get();
        $data = [
            'user' => $user,
            'list_purchase' => $list_purchase
        ];
        return view("admin.purchase_order.index", $data);
    }

    public function add()
    {
        // add view category
        $user = Auth::user();
        $list_supplier = Supplier::get();
        $data = [
            'user' => $user,
            'list_supplier' => $list_supplier
        ];
        return view("admin.purchase_order.add", $data);
    }

    public function do_add(Request $request)
    {
        // add purchase order to database
        try {
            DB::beginTransaction();
            $list_produk = json_decode($request->list_produk);
            $data = new HeaderPurchaseOrder();
            $data->id_supplier = $request->id_supplier;
            $data->order_number = $request->order_number;
            $data->created_date = $request->created_date;
            $data->status = 0;
            $data->save();

            foreach ($list_produk as $lp) {
                DetailPurchaseOrder::add_detail($data->id, $lp->id_product, $lp->id_unit, NULL, $lp->qty, NULL);
            }

            DB::commit();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/purchase_order");
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function edit($id)
    {
        // edit view category
        $user = Auth::user();
        $data_purchase_order = HeaderPurchaseOrder::find($id);
        $data_product = DetailPurchaseOrder::where("d_purchase_order.id_h_purchase_order", $id)
            ->join("inventory", "inventory.id", "=", "d_purchase_order.id_inventory")
            ->join("unit", "unit.id", "=", "d_purchase_order.id_unit")
            ->select("d_purchase_order.*", "inventory.name as product_name", "unit.name as unit_name", "inventory.code as product_code")
            ->get();
        $list_supplier = Supplier::get();
        $data = [
            'user' => $user,
            'data_purchase_order' => $data_purchase_order,
            'list_supplier' => $list_supplier,
            'data_product' => $data_product
        ];
        return view("admin.purchase_order.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit po to database
        try {
            DB::beginTransaction();
            $list_produk = json_decode($request->list_produk);
            $data = HeaderPurchaseOrder::where("id", $id)->first();
            $data->id_supplier = $request->id_supplier;
            $data->order_number = $request->order_number;
            $data->status = 1;
            $data->save();

            DetailPurchaseOrder::where("id_h_purchase_order", $id)->delete();
            foreach ($list_produk as $lp) {
                DetailPurchaseOrder::add_detail($data->id, $lp->id_product, $lp->id_unit, NULL, $lp->qty, $lp->price);
            }

            DB::commit();
            CommonHelper::showAlert("Success", "Kirim pesanan ke supplier berhasil", "success", "/admin/purchase_order");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            DB::rollBack();
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function delete(Request $request)
    {
        // delete category from database
        try {
            HeaderPurchaseOrder::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/purchase_order");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function finish($id)
    {
        $user = Auth::user();
        $data_purchase_order = HeaderPurchaseOrder::find($id);
        $data_product = DetailPurchaseOrder::where("d_purchase_order.id_h_purchase_order", $id)
            ->join("inventory", "inventory.id", "=", "d_purchase_order.id_inventory")
            ->join("unit", "unit.id", "=", "d_purchase_order.id_unit")
            ->select("d_purchase_order.*", "inventory.name as product_name", "unit.name as unit_name", "inventory.code as product_code")
            ->get();
        $list_supplier = Supplier::get();
        $data = [
            'user' => $user,
            'data_purchase_order' => $data_purchase_order,
            'list_supplier' => $list_supplier,
            'data_product' => $data_product
        ];
        return view("admin.purchase_order.finish", $data);
    }

    public function do_finish($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $list_produk = json_decode($request->list_produk);
            $data = HeaderPurchaseOrder::where("id", $id)->first();
            if ($request->is_finish === '1') {
                $data->status = 2;
                $data->finish_date = $request->finish_date;
            }
            $data->grand_total = (int)$data->grand_total + (int)$request->grand_total;
            $data->save();

            foreach ($list_produk as $lp) {
                DetailPurchaseOrder::terima_barang($data->id, $lp->id_product, $lp->id_unit, $lp->expdate, $lp->qty);
                Unit::add_stok($lp->id_unit, $lp->qty);
            }

            DB::commit();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/purchase_order");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            DB::rollBack();
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function view($id)
    {
        $user = Auth::user();
        $data_purchase_order = HeaderPurchaseOrder::find($id);
        $data_product = DetailPurchaseOrder::where("d_purchase_order.id_h_purchase_order", $id)
            ->join("inventory", "inventory.id", "=", "d_purchase_order.id_inventory")
            ->join("unit", "unit.id", "=", "d_purchase_order.id_unit")
            ->select("d_purchase_order.*", "inventory.name as product_name", "unit.name as unit_name", "inventory.code as product_code")
            ->get();
        $list_supplier = Supplier::get();
        $data = [
            'user' => $user,
            'data_purchase_order' => $data_purchase_order,
            'list_supplier' => $list_supplier,
            'data_product' => $data_product
        ];
        return view("admin.purchase_order.view", $data);
    }
}
