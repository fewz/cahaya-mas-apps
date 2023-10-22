<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function doLogin(Request $request)
    {
        // login user
        $username = $request->username;
        $password = $request->password;
        // print_r(Customer::check_user($username, $password));
        $customer = Customer::check_user($request->username, $password);
        Auth::attempt(['username' => $username, 'password' => $password]);


        if (Auth::check()) {
            $user = Auth::user();
            // print_r($user->id_role);
            $permission = PermissionRole::get_permission($user->id_role);
            foreach ($permission as $p) {
                Session::put($p->description, true);
            }
            return redirect()->route('dashboard');
        } else if ($customer !== null) {
            Session::put('customer_data', $customer);
            return redirect()->route('customer/pesanan_saya');
        } else {
            CommonHelper::showAlert("Sign In Failed", "Username atau password salah", "error", "/");
        }
    }

    public function logout()
    {
        // logout user
        Session::flush();
        Auth::logout();
        CommonHelper::showAlert("Sukses", "Logout Berhasil", "success", "/");
    }

    public function no_access()
    {
        return view("no_access");
    }
}
