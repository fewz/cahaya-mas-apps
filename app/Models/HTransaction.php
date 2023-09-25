<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HTransaction extends Model
{
    protected $table = 'h_transaction';
    public $timestamps = false;

    public static function get_list_transaction($id_cashier)
    {
        $data = HTransaction::where('h_transaction.id_cashier', $id_cashier)
            ->join('customer', 'customer.id', 'h_transaction.id_customer')
            ->join('users', 'users.id', 'h_transaction.id_cashier')
            ->select('h_transaction.*', 'customer.full_name as customer_name', 'users.username as cashier_name')
            ->get();
        return $data;
    }
}
