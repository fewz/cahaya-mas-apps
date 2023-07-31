<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryUnit extends Model
{
    protected $table = 'inventory_unit';
    public $timestamps = false;

    public static function add_inventory_unit($id_inventory, $id_unit)
    {
        // add unit to inventory_unit database
        $data = new InventoryUnit();
        $data->id_inventory = $id_inventory;
        $data->id_unit = $id_unit;
        $data->save();
    }
}
