<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $defaultPaginate = config('crud.paginate.default');

        $permissions = Permission::paginate($defaultPaginate);

        return view('admin.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => ['required']
        ]);

        $displayName = $request->input('display_name', null);
        $description = $request->input('description', null);
        $name        = Str::slug($displayName, '-');

        $permissionObj = new Permission();

        $permissionObj->name         = $name;
        $permissionObj->display_name = $displayName;
        $permissionObj->description  = $description;
        $res = $permissionObj->save();
        if ($res) {
            return redirect()->route('permissions.index')->with('message', 'Permission create successfully');
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
        $permission = Permission::find($id);

        return view('admin.permission.edit', [
            'permission' => $permission
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

        $permissionObj = Permission::find($id);

        $permissionObj->name         = $name;
        $permissionObj->display_name = $displayName;
        $permissionObj->description  = $description;
        $res = $permissionObj->save();
        if ($res) {
            return redirect()->route('permissions.index')->with('message', 'Permission updated successfully');
        } else {
            return back()->with('message', 'Something went to wrong');
        }
    }

    public function destroy($id)
    {
        //
    }
}
