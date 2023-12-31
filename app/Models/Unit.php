<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    public $timestamps = false;
    public static function add_unit($id_inventory, $name, $qty_reference)
    {
        $data = new Unit();
        $data->id_inventory = $id_inventory;
        $data->name = $name;
        $data->qty_reference = $qty_reference;
        $data->hpp = 0;
        $data->save();

        return $data->id;
    }

    public static function edit_unit($id_unit, $id_inventory, $name, $qty_reference)
    {
        $data = Unit::where("id", $id_unit)->first();
        $data->id_inventory = $id_inventory;
        $data->name = $name;
        $data->qty_reference = $qty_reference;
        $data->save();

        return $data->id;
    }

    public static function hitung_stok_terkecil($id_inventory)
    {
        $data = Unit::where("id_inventory", $id_inventory)->orderBy('qty_reference')->get();
        $result = 0;
        foreach ($data as $unit) {
            if ($unit->qty_reference === NULL) {
                $result += $unit->stok;
            } else {
                $result += ($unit->stok * $unit->qty_reference);
            }
        }
        return $result;
    }

    public static function update_hpp($qty, $id_unit, $price)
    {
        $unit = Unit::find($id_unit);

        $hpp_baru = (($unit->hpp * $unit->stok) + ($price * $qty)) / ($unit->stok + $qty);
        $unit->hpp = $hpp_baru;
        $unit->save();
    }

    public static function get_unit_terkecil($id_inventory)
    {
        $data = Unit::where("id_inventory", $id_inventory)->where("qty_reference", NULL)->first();
        return $data->id;
    }

    public static function add_stok($id_unit, $stok)
    {
        $unit = Unit::find($id_unit);
        $unit->increment('stok', $stok);
        return $unit->stok;
    }

    public static function minus_stok($id_unit, $stok)
    {
        $unit = Unit::find($id_unit);
        $unit->decrement('stok', $stok);
        return $unit->stok;
    }
}
