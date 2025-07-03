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

    try {
        $import = new StudentImport($request->major_id, $request->class_id);
        Excel::import($import, $request->file('file'));

        return response()->json([
            'message' => count($import->duplicates) > 0
                ? 'Import selesai. Sebagian siswa sudah ada.'
                : 'Import selesai tanpa duplikat.',
            'duplicates' => $import->duplicates,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat import.',
            'error' => $e->getMessage(),
        ], 500);
    }
}





    public function destroy($classId, $studentId)
    {
        $class = Classes::findOrFail($classId);
        $class->students()->detach($studentId);

        return back()->with('success', 'Student removed from class.');
    }


}
