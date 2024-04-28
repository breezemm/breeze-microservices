<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();

        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        Role::create($validated);

        return response()->json(['message' => 'Role created successfully']);
    }

    public function show(Role $role)
    {
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate(['name' => ['required', 'min:3', 'lowercase:role', 'unique:roles,name,' . $role->id . ',id']]);
        $role->update($validated);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->noContent();
    }

    public function givePermission(Request $request, Role $role)
    {
        if ($role->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission exists.');
        }
        $role->givePermissionTo($request->permission);

        return back()->with('message', 'Permission added.');
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);

            return back()->with('message', 'Permission revoked.');
        }

        return back()->with('message', 'Permission not exists.');
    }
}
