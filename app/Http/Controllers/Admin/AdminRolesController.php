<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRolesController extends Controller
{
    //
    public function showRoleList(){
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.list',compact('roles'));
    }

    public function removePermission(Request $request){
        $permission = Permission::findOrFail($request->permissionId);
        $role = Role::findOrFail($request->roleId);

        $role->revokePermissionTo($permission);

        //渲染
        $status = 1;
        $msg = "The role has been removed";
        return json_encode(compact('status','msg'));//ajax

    }

    public function showCreatRole(){
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required'
        ]);

        $role = Role::create(['name' => $request->name]);
        if (!empty($request->permission_id)){
            $role->syncPermissions($request->permission_id);
        }
        return \redirect()->back()->with('tips', ['角色创建成功',]);

    }

    public function showEditRole(Role $role){
        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

    public function update(Role $role,Request $request){
        $this->validate($request,[
            'name'=>'required'
        ]);

        $role->update(['name' => $request->name]);
        if (!empty($request->permission_id)){
            $role ->syncPermissions($request->permission_id);
        }
        return \redirect()->back()->with('tips', ['角色编辑成功',]);

    }

    public function delete(Request $request){
        Role::findOrFail($request->id)->delete();

        $status = 1;
        $msg = "The Role has been deleted";
        return json_encode(compact('status','msg'));//ajax
    }
}
