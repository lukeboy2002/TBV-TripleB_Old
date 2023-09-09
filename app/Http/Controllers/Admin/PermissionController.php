<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $permission = Permission::create([
            'name' => $request['name'],
        ]);

        $role = Role::select('id')->where('name', 'admin')->first();

        $permission->roles()->attach($role);

        $request->session()->flash('success', 'Permission successfully created.');
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(permission $permission)
    {
        $roles = Role::all();

        return view('admin.permissions.edit',[
            'permission' => $permission,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update([
            'name' => $request['name'],
        ]);

        $request->session()->flash('success', 'Permissions successfully updated.');
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(permission $permission)
    {
        //
    }

    public function assignRole(Request $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {
            $request->session()->flash('error', 'Role already exists on permission.');
            return back();
        }

        $permission->assignRole($request->role);
        $request->session()->flash('success', 'Role successfully added to permission.');
        return back();
    }

    public function removeRole(Request $request, Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);

            $request->session()->flash('success', 'Role successfully removed from permission.');
            return back();
        }

        $request->session()->flash('error', 'Role not exists.');
        return back();
    }
}
