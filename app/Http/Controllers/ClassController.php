<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassStudent;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('homeroomTeacher')->get();
        return view('admin.class.index', compact('classes'));
    }

    public function create()
    {
        $majors = Major::all();
        $teachers = User::where('role_id', Role::GURU)->get();
        return view('admin.class.create', compact('teachers', 'majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'homeroom_teacher_id' => 'required|exists:users,id',
            'semester' => 'required|string|max:20',
            'year' => 'required|string|max:10',
            'class_chief' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'major_id' => 'required'
        ]);

        Classes::create([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
            'semester' => $request->semester,
            'year' => $request->year,
            'class_chief' => $request->class_chief,
            'status' => $request->status,
            'major_id' => $request->major_id
        ]);

        return redirect()->route('class.index')->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);

        // Ambil semua guru dengan role_id = 2
        $teachers = User::where('role_id', Role::GURU)->get();

        // Ambil semua siswa yang sudah masuk ke kelas ini
        $classStudents = ClassStudent::with('student')->where('class_id', $id)->get();

        // Ambil semua student_id yang sudah punya kelas (class_student)
        $studentWithClass = ClassStudent::pluck('student_id');

        // Ambil siswa yang belum punya kelas
        $students = Student::whereNotIn('id', $studentWithClass)->get();

        $majors = Major::all();


        return view('admin.class.edit', compact('class', 'teachers', 'classStudents', 'students', 'majors'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'homeroom_teacher_id' => 'required|exists:users,id',
            'semester' => 'required|string|max:20',
            'year' => 'required|string|max:10',
            'class_chief' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'major_id' => 'required'
        ]);

        $class = Classes::findOrFail($id);
        $class->update([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
            'semester' => $request->semester,
            'year' => $request->year,
            'class_chief' => $request->class_chief,
            'status' => $request->status,
            'major_id' => $request->major_id,
        ]);

        return redirect()->route('class.index')->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->route('class.index')->with('success', 'Class deleted successfully.');
    }
}
