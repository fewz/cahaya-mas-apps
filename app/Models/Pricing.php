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
}
