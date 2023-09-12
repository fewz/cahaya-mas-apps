<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transaction extends Controller
{
    public function index()
    {
        // list view stock
        $user = Auth::user();
        $list_stock = DB::table('stock')
            ->join('inventory', 'inventory.id', '=', 'stock.id_inventory')
            ->join('unit', 'unit.id', '=', 'stock.id_unit')
            ->select('stock.*', 'inventory.name as inventory', 'unit.name as unit')
            ->get();
        $data = [
            'user' => $user,
            'list_stock' => $list_stock
        ];
        return view("admin.inventory.stock.index", $data);
    }
}
