<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Collection;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.roles');
    }

    public function index()
    {
        $roles = Role::all();

        return view('backend.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255|unique:roles,name',
            'slug' => 'max:255|alpha_dash|unique:roles,slug',
            'level' => 'numeric|min:1',
            'description' => 'max:255'
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->slug = $request->slug;
        $role->level = $request->level;
        $role->description = $request->description;

        $role->save();

        return redirect()->route('backend.role.edit', $role)
               ->with('success', trans('backend.saved'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Role $role)
    {
        $permissionsCollection = Permission::all();

        $permissions = [];
        foreach ($permissionsCollection as $permission) {
            $group = explode('.', $permission->slug)[0];
            $permissions[trans('backend.permissions.'.$group)][$permission->id] = $permission->name;
        }

        if ($role->permissions !== null) {
            $currentPermissions = $role->permissions->map(function ($item) {
                return $item->id;
            })->all();
        } else {
            $currentPermissions = [];
        }

        $lowerRoles = Role::where('level', '<', $role->level)->get();
        $permissionsCollection = new Collection;

        foreach ($lowerRoles as $lowerRole) {
            $permissionsCollection = $permissionsCollection->merge($lowerRole->permissions);
        }

        $permissionsCollection = $permissionsCollection->merge($role->permissions);

        $effectivePermissions = [];
        foreach ($permissionsCollection as $permission) {
            $group = explode('.', $permission->slug)[0];
            $effectivePermissions[trans('backend.permissions.'.$group)][$permission->id] = $permission->name;
        }

        return view('backend.roles.edit', compact('role', 'permissions', 'currentPermissions', 'effectivePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'max:255|unique:roles,name,'.$role->id,
            'slug' => 'max:255|alpha_dash|unique:roles,slug,'.$role->id,
            'level' => 'numeric|min:1',
            'description' => 'max:255',
            'permissions' => 'array|exists:permissions,id',
        ]);

        $role->name = $request->name;
        $role->slug = $request->slug;
        $role->level = $request->level;
        $role->description = $request->description;

        $role->save();

        $role->detachAllPermissions();
        if ($request->permissions !== null) {
            foreach ($request->permissions as $permission) {
                $role->attachPermission(Permission::find($permission));
            }
        }

        return redirect()->route('backend.role.edit', $role)
               ->with('success', trans('backend.saved'));
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('backend.role.index')
               ->with('success', trans('backend.role_deleted', ['role' => $role->name]));
    }
}
