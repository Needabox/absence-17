<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Clas::with('homeroomTeacher')->get();
        return view('admin.class.index', compact('classes'));
    }

    public function create()
    {
        $teachers = User::where('role_id', 2)->get();
        return view('admin.class.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'homeroom_teacher_id' => 'required|exists:users,id',
        ]);

        Clas::create([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
        ]);

        return redirect()->route('class.index')->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        $class = Clas::findOrFail($id);
        $teachers = User::where('role_id', 2)->get();
        return view('admin.class.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'homeroom_teacher_id' => 'required|exists:users,id',
        ]);

        $class = Clas::findOrFail($id);
        $class->update([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
        ]);
        return redirect()->route('class.index')->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $class = Clas::findOrFail($id);
        $class->delete();
        return redirect()->route('class.index')->with('success', 'deleted successfully.');
    }
}
