<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Customer extends Model
{
    protected $table = 'customer';
    public $timestamps = false;


    public static function add_poin($id_customer, $grand_total)
    {
        $minimal_belanja = Setting::where('name', '=', 'MINIMAL_BELANJA_CASHBACK_POINT')->first();
        $poin = Setting::where('name', '=', 'NILAI_CASHBACK_POIN_RUPIAH')->first();
        if ($minimal_belanja->value <= $grand_total) {
            $customer = Customer::where("id", $id_customer)->first();
            $customer->poin += floor($grand_total / $minimal_belanja->value) * $poin->value;
            $customer->save();
        }
    }

    public static function check_user($email, $password)
    {
        $customer = Customer::where('email', $email)->first();
        if (!$customer) {
            return null;
        }

        if (Hash::check($password, $customer->password)) {
            return $customer;
        }
        return null;
    }

    public static function get_login_customer()
    {
        $customer = Session::get('customer_data');
        return $customer;
    }
}
