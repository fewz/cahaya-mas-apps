<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
    protected $table = 'product_supplier';
    public $timestamps = false;

    public static function add_product_supplier($id_product, $id_supplier)
    {
        $data = new ProductSupplier();
        $data->id_product = $id_product;
        $data->id_supplier = $id_supplier;
        $data->save();
    }
}
