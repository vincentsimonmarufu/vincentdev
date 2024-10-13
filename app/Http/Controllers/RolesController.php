<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        // Create the role
        Role::create(['name' => strtolower($request->name)]);

        // Redirect with a success message
        return redirect()->route('roles.index')->with('status', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        // Find the role and update it
        $role = Role::findOrFail($id);
        $role->name = strtolower($request->name);
        $role->save();

        // Redirect with a success message
        return redirect()->route('roles.index')->with('status', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('status', 'Role deleted successfully!');
    }

    public function editPermissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('roles.assign-permissions', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validate the request
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // Ensures all permission IDs exist
        ]);

        // Get permission names from the IDs
        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
        // Sync permissions with the role using names
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('status', 'Permissions assigned successfully.');
    }
}
