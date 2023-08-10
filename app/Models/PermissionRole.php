<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';
    public $timestamps = false;

    public static function add_permission_role($id_role, $id_permission)
    {
        // add permission to permission_role database
        $data = new PermissionRole();
        $data->id_role = $id_role;
        $data->id_permission = $id_permission;
        $data->save();
    }
}