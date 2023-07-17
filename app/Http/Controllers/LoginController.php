<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function doLogin(Request $request)
    {

        $username = $request->username;
        $password = $request->password;
        Auth::attempt(['username' => $username, 'password' => $password]);

        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            CommonHelper::showAlert("Sign In Failed", "Username atau password salah", "error", "/");
        }
    }

    public function logout()
    {
        Auth::logout();
        CommonHelper::showAlert("Sukses", "Logout Berhasil", "success", "/");
    }
}
