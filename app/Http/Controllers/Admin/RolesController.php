<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('roles.index')->with('success', 'role created successfully.');
    }

    public function edit(string $id)
    {
        $roles = Role::find($id);
        return view('admin.roles.edit', compact('roles'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:4'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        return redirect()->route('roles.index')->with('success', 'role update successfully.');
    }

    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'role delete successfully.');
    }
}
