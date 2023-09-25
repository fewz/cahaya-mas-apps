<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\LogTerimaBarang;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // list view user
        $user = Auth::user();
        $list_user = DB::table('users')
            ->join('role', 'users.id_role', '=', 'role.id')
            ->select('users.*', 'role.name as role_name')
            ->get();
        $data = [
            'user' => $user,
            'list_user' => $list_user
        ];
        return view("admin.user.index", $data);
    }

    public function add()
    {
        // add view user
        $user = Auth::user();
        $list_role = Role::get();
        $data = [
            'user' => $user,
            'list_role' => $list_role
        ];
        return view("admin.user.add", $data);
    }

    public function do_add(Request $request)
    {
        // add user to database
        try {
            $data = new User();
            $data->username = $request->username;
            $data->password = Hash::make($request->password); // hash password before saving to db
            $data->id_role = $request->id_role;
            $data->save();
            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_user");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            if (str_contains($ex->getMessage(), 'Duplicate entry')) {
                CommonHelper::showAlert(
                    "Failed",
                    'Username ' . $request->username . ' already used',
                    "error",
                    "back"
                );
            } else {
                CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
            }
        }
    }

    public function edit($id)
    {
        // edit view user
        $user = Auth::user();
        $data_user = User::find($id);
        $list_role = Role::get();
        $data = [
            'user' => $user,
            'data_user' => $data_user,
            'list_role' => $list_role
        ];
        return view("admin.user.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit user to database
        try {
            $data = User::where("id", $id)->first();
            $data->username = $request->username;
            $data->id_role = $request->id_role;
            $data->password = Hash::make($request->password); // hash password before saving to db
            $data->save();
            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_user");
        } catch (\Illuminate\Database\QueryException $ex) {
            if (str_contains($ex->getMessage(), 'Duplicate entry')) {
                CommonHelper::showAlert(
                    "Failed",
                    'Username ' . $request->username . ' already used',
                    "error",
                    "back"
                );
            } else {
                CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
            }
        }
    }

    public function delete(Request $request)
    {
        // delete user
        try {
            User::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_user");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function test(Request $request){
        echo LogTerimaBarang::get_total_pengiriman(20);
    }

    public function tests(Request $request){
        echo "tes";
    }
}
