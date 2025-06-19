<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::all();
        return view('admin.majors.index', compact('majors'));
    }

    public function create()
    {
        $majors = Major::all();
        return view('admin.majors.create', compact('majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Major::create($request->all());

        return redirect()->route('majors.index')->with('success', 'Major created successfully.');
    }

   

    public function edit(Major $major)
    {
        return view('admin.majors.edit', compact('major'));
    }

    public function update(Request $request, Major $major)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $major->update($request->all());

        return redirect()->route('majors.index')->with('success', 'Major updated successfully.');
    }

    public function destroy(Major $major)
    {
        $major->delete();
        return redirect()->route('majors.index')->with('success', 'Major deleted successfully.');
    }
}
