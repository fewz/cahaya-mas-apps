<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTerimaBarang extends Model
{
    protected $table = 'log_terima_barang';
    public $timestamps = false;

    public static function add_log($id_inventory, $id_h_purchase_order, $id_unit, $qty){
        $data = new LogTerimaBarang();
        $data->id_inventory = $id_inventory;
        $data->id_h_purchase_order = $id_h_purchase_order;
        $data->id_unit = $id_unit;
        $data->qty = $qty;
        $data->save();
    }
}
