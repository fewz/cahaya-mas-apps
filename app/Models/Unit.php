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
        $data->save();

        return $data->id;
    }
}
