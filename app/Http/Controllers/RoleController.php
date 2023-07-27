<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        // list view role
        $user = Auth::user();
        $list_role = DB::table('role')->get();
        $data = [
            'user' => $user,
            'list_role' => $list_role
        ];
        return view("admin.role.index", $data);
    }


    public function add()
    {
        // add view role
        $user = Auth::user();
        $list_permission = Permission::get();
        $data = [
            'user' => $user,
            'list_permission' => $list_permission
        ];
        return view("admin.role.add", $data);
    }

    public function do_add(Request $request)
    {
        // add role to database
        try {
            $role = new Role();
            $role->name = strtoupper($request->name);
            $role->save();

            if (isset($request->permission)) {
                // add permission to permission_role database
                foreach ($request->permission as $permission_id) {
                    PermissionRole::add_permission_role($role->id, $permission_id);
                }
            }

            CommonHelper::showAlert("Success", "Insert data success", "success", "/admin/master_role");
        } catch (\Illuminate\Database\QueryException $ex) {
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }

    public function edit($id)
    {
        // edit view role
        $user = Auth::user();
        $data_role = Role::find($id);
        $data_permission = PermissionRole::where('id_role', $id)->get('id_permission');
        foreach ($data_permission as $key => $value) {
            // mapping id permission to show on view template
            $data_permission[$key] = $value->id_permission;
        }
        $list_permission = Permission::get();
        $data = [
            'user' => $user,
            'data_role' => $data_role,
            'data_permission' => $data_permission,
            'list_permission' => $list_permission
        ];
        return view("admin.role.edit", $data);
    }

    public function do_edit($id, Request $request)
    {
        // edit role to database
        try {
            $data = Role::where("id", $id)->first();
            $data->name = strtoupper($request->name);
            $data->save();

            // delete previous existing permission_role database
            PermissionRole::where("id_role", $request->id)->delete();

            if (isset($request->permission)) {
                // add permission to permission_role database
                foreach ($request->permission as $permission_id) {
                    PermissionRole::add_permission_role($id, $permission_id);
                }
            }

            CommonHelper::showAlert("Success", "Edit data success", "success", "/admin/master_role");
        } catch (\Illuminate\Database\QueryException $ex) {
            if (str_contains($ex->getMessage(), 'Duplicate entry')) {
                // catch error
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
        // delete role
        try {
            // delete permission_role first
            PermissionRole::where("id_role", $request->id)->delete();
            //delete role
            Role::where("id", $request->id)->delete();
            CommonHelper::showAlert("Success", "Delete data success", "success", "/admin/master_role");
        } catch (\Illuminate\Database\QueryException $ex) {
            // catch error
            CommonHelper::showAlert("Failed", $ex->getMessage(), "error", "back");
        }
    }
}
