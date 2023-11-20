<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTerimaBarang extends Model
{
    protected $table = 'log_terima_barang';
    public $timestamps = false;

    public static function add_log($id_inventory, $id_h_purchase_order, $id_unit, $qty, $exp_date, $total_pengiriman, $keterangan, $stok_akhir)
    {

        $data = new LogTerimaBarang();
        $data->id_inventory = $id_inventory;
        $data->id_h_purchase_order = $id_h_purchase_order;
        $data->id_unit = $id_unit;
        $data->qty = $qty;
        $data->exp_date = $exp_date;
        $data->pengiriman_ke = $total_pengiriman + 1;
        $data->keterangan = $keterangan;
        $data->stok_akhir = $stok_akhir;
        $data->save();
    }

    public static function get_total_pengiriman($id_h_purchase_order)
    {
        return LogTerimaBarang::where('id_h_purchase_order', $id_h_purchase_order)->distinct('pengiriman_ke')->count();
    }
}
