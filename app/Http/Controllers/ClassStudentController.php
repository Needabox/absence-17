<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Classes;
use App\Models\Student;
use App\Imports\StudentImport;
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
    
 public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
        'major_id' => 'required|integer',
        'class_id' => 'required|integer',
    ]);

    $import = new \App\Imports\StudentImport($request->major_id, $request->class_id);
    \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));

    if (count($import->duplicates) > 0) {
        return back()->with('success', 'Import selesai. Sebagian siswa sudah ada: ' . implode(', ', $import->duplicates));
    }

    return back()->with('success', 'Import selesai tanpa duplikat.');
}



    

    public function destroy($classId, $studentId)
    {
        $class = Classes::findOrFail($classId);
        $class->students()->detach($studentId);

        return back()->with('success', 'Student removed from class.');
    }


}
