<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // $list_role = DB::table('role')->get();
        $data = [
            'user' => $user,
            // 'list_role' => $list_role
        ];
        return view("admin.supplier.index", $data);
    }
}
