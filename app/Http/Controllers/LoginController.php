<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
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
        Auth::attempt(['username' => $username, 'password' => $password]);

        if (Auth::check()) {
            $user = Auth::user();
            // print_r($user->id_role);
            $permission = PermissionRole::get_permission($user->id_role);
            foreach ($permission as $p) {
                Session::put($p->description, true);
            }
            return redirect()->route('dashboard');
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
}
