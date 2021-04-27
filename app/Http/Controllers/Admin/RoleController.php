<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->paginate(50);
        return view('admin.settings.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        $permissionArr = [];
        foreach($permissions as $per) {
            $permissionArr[$per->module][] = (object) [
                'id' => $per->id,
                'name' => $per->name,
            ];
        }

        return view('admin.settings.role.create-edit', compact('permissionArr'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('admin.setting.role.index', qArray())->withSuccess('Role created successfully.');
    }

    public function show(Request $request, $id)
    {
        $data = Role::find($id);

        if (empty($data)) {
            return redirect()->route('admin.setting.role.index', qArray());
        }

        $permissionArr = [];
        foreach($data->permissions as $per) {
            $permissionArr[$per->module][] = (object) [
                'id' => $per->id,
                'name' => $per->name,
            ];
        }

        $rolePermission = [];
        foreach ($data->permissions as $r) {
            $rolePermission[$r->module][] = $r->name;
        }

        return view('admin.settings.role.details', compact('data', 'permissionArr', 'rolePermission'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $data = Role::find($id);

        if (empty($data)) {
            return redirect()->route('admin.setting.role.index', qArray());
        }

        $permissions = Permission::all();
        $permissionArr = [];
        foreach($permissions as $per) {
            $permissionArr[$per->module][] = (object) [
                'id' => $per->id,
                'name' => $per->name,
            ];
        }

        $rolePermission = [];
        foreach ($data->permissions as $r) {
            $rolePermission[$r->module][] = $r->name;
        }

        return view('admin.settings.role.create-edit', compact('data', 'permissionArr', 'rolePermission'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $data = Role::find($id);

        if (empty($data)) {
            return redirect()->route('admin.setting.role.index', qArray());
        }

        $data->update(['name' => $request->name]);
        $data->syncPermissions($request->permissions);

        return redirect()->route('admin.setting.role.index', qArray())->withSuccess('Role successfully updated!');
    }

    public function destroy(Request $request,$id)
    {
        $data = Role::find($id);
        if (empty($data)) {
            return redirect()->route('admin.setting.role.index', qArray());
        }
        $data->delete();
        return redirect()->route('admin.setting.role.index', qArray())->withSuccess('Role successfully deleted!');
    }
}
