<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassStudentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $class = Classes::findOrFail($request->class_id);

        // prevent duplicate
        if ($class->students()->where('student_id', $request->student_id)->exists()) {
            return back()->with('error', 'Student already added to this class.');
        }

        $class->students()->attach($request->student_id);

        return back()->with('success', 'Student added to class.');
    }

    public function destroy($classId, $studentId)
    {
        $class = Classes::findOrFail($classId);
        $class->students()->detach($studentId);

        return back()->with('success', 'Student removed from class.');
    }
}
