<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $defaultPaginate = config('crud.paginate.default');
        $roles = Role::paginate($defaultPaginate);

        return view('admin.role.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = Permission::get();

        return view('admin.role.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => ['required']
        ]);

        $displayName = $request->input('display_name', null);
        $description = $request->input('description', null);
        $name        = Str::slug($displayName, '-');

        $roleObj = new Role();

        $roleObj->name         = $name;
        $roleObj->display_name = $displayName;
        $roleObj->description  = $description;
        $res = $roleObj->save();

        if ($res) {
            $permissionIDs = $request->input('permission_ids', []);
            $roleObj->syncPermissions($permissionIDs);

            return redirect()->route('roles.index')->with('message', 'Role create successfully');
        } else {
            return back()->with('message', 'Something went to wrong');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role           = Role::find($id);
        $permissions    = Permission::all();
        $permission_ids = $role->permissions()->pluck('id')->toArray();

        return view('admin.role.edit', [
            'role'           => $role,
            'permissions'    => $permissions,
            'permission_ids' => $permission_ids,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'display_name' => ['required']
        ]);

        $displayName = $request->input('display_name', null);
        $description = $request->input('description', null);
        $name        = Str::slug($displayName, '-');

        $role = Role::find($id);
        $role->name = $name;
        $role->display_name = $displayName;
        $role->description = $description;
        $res = $role->save();

        if ($res) {
            $permissionIDs = $request->input('permission_ids', []);
            $role->syncPermissions($permissionIDs);

            return redirect()->route('roles.index')->with('message', 'Role updated successfully');
        } else {
            return back()->with('message', 'Something went to wrong');
        }
    }

    public function destroy($id)
    {
        //
    }
}
