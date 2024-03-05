<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        Permission::create($validated);
        return response()->json(['message' => 'Permission created successfully']);
    }

    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate(['name' => 'required']);
        $permission->update($validated);

        return response()->json(['message' => 'Permission updated successfully']);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->noContent();
    }

    public function assignRole(Request $request, Permission $permission)
    {
        abort_if($permission->hasRole($request->role), 'Role already exists.');

        $permission->assignRole($request->role);
        return response()->json(['message' => 'Role assigned.']);
    }

    public function removeRole(Permission $permission, Role $role)
    {
        abort_if(!$permission->hasRole($role), 404, 'Role not exists.');

        $permission->removeRole($role);
        return response()->json(['message' => 'Role removed.']);
    }
}
