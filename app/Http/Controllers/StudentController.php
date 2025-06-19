<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Major;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('major')->get();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $majors = Major::all();
        return view('admin.students.create', compact('majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|integer',
            'nis' => 'required|string|unique:students,nis',
            'nisn' => 'nullable|string',
            'major_id' => 'required|exists:majors,id',
            'status' => 'required|integer',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $majors = Major::all();
        return view('admin.students.edit', compact('student', 'majors'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|integer',
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'nisn' => 'nullable|string',
            'major_id' => 'required|exists:majors,id',
            'status' => 'required|integer',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
