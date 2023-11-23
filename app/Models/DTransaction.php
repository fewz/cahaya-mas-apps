<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DTransaction extends Model
{
    protected $table = 'd_transaction';
    public $timestamps = false;

    public static function add_detail($id_header, $id_inventory, $id_unit, $sell_price, $qty, $sub_total, $diskon, $stok_akhir)
    {
        $unit = Unit::find($id_unit);

        $data = new DTransaction();
        $data->id_h_transaction = $id_header;
        $data->id_inventory = $id_inventory;
        $data->id_unit = $id_unit;
        $data->sell_price = $sell_price;
        $data->qty = $qty;
        $data->sub_total = $sub_total;
        $data->diskon = $diskon;
        $data->hpp = $unit->hpp;
        $data->netto = ($sell_price - $unit->hpp) * $qty;
        $data->stok_akhir = $stok_akhir;
        $data->save();

        return $data->netto;
    }
}
