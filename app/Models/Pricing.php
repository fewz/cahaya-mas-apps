<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $table = 'tier_pricing';
    public $timestamps = false;


    public static function add_pricing($id_inventory, $id_unit, $tier_customer, $sell_price)
    {
        $data = new Pricing();
        $data->id_inventory = $id_inventory;
        $data->id_unit = $id_unit;
        $data->tier_customer = $tier_customer;
        $data->sell_price = $sell_price;
        $data->save();
    }

    public static function get_harga_general_list_inventory($id_inventory)
    {
        $id_unit_terkecil = Unit::get_unit_terkecil($id_inventory);
        $data = Pricing::where('id_inventory', $id_inventory)->where('id_unit', $id_unit_terkecil)->orderBy("tier_customer")->get();

        //orderby tier_customer -> bronze, general, gold, silver
        $result = [
            number_format($data[1]->sell_price, 0, ",", "."),
            number_format($data[0]->sell_price, 0, ",", "."),
            number_format($data[3]->sell_price, 0, ",", "."),
            number_format($data[2]->sell_price, 0, ",", "."),
        ];
        return $result;
    }
}
