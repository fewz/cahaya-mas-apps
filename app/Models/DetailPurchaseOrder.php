<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPurchaseOrder extends Model
{
    protected $table = 'd_purchase_order';
    public $timestamps = false;

    public static function add_detail($id_header, $id_inventory, $id_unit, $date_expired, $qty, $price_buy)
    {
        $data = new DetailPurchaseOrder();
        $data->id_h_purchase_order = $id_header;
        $data->id_inventory = $id_inventory;
        $data->id_unit = $id_unit;
        $data->date_expired = $date_expired;
        $data->qty = 0;
        $data->order_qty = $qty;
        $data->sisa_qty = $qty;
        $data->price_buy = $price_buy;
        $data->save();
    }

    public static function terima_barang($id_header, $id_inventory, $id_unit, $date_expired, $qty)
    {
        $data = DetailPurchaseOrder::where('id_h_purchase_order', $id_header)
            ->where('id_inventory', $id_inventory)
            ->where('id_unit', $id_unit)
            ->first();
        $data->date_expired = $date_expired;
        $data->qty = (int)$data->qty + (int)$qty;
        $data->sisa_qty = (int)$data->sisa_qty - (int)$qty;
        $data->save();

        LogTerimaBarang::add_log($id_inventory, $id_header, $id_unit, $qty);
    }
}
