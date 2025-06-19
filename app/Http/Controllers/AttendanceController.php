<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassStudent;
use App\Models\Student;
use App\Models\UserClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userClass = UserClass::where('user_id', Auth::id())->first();

        if (!$userClass) {
            return abort(403, 'User tidak terdaftar di kelas manapun');
        }

        $kelas = $userClass->class;
        $students = ClassStudent::where('class_id', $userClass->class_id)->get();
        $today = now()->toDateString();

        // Cek apakah semua siswa di kelas ini sudah ada data absensi hari ini
        $attendanceCount = \App\Models\Attendance::where('class_id', $kelas->id)
            ->where('date', $today)
            ->count();

        $studentCount = $students->count();



        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $statistik = [
            'hadir' => Attendance::whereMonth('date', $month)->whereYear('date', $year)->where('status', 1)->count(),
            'sakit' => Attendance::whereMonth('date', $month)->whereYear('date', $year)->where('status', 2)->count(),
            'izin'  => Attendance::whereMonth('date', $month)->whereYear('date', $year)->where('status', 3)->count(),
            'alpa'  => Attendance::whereMonth('date', $month)->whereYear('date', $year)->where('status', 4)->count(),
        ];

        // Ambil siswa dari kelas user
        $studentIds = ClassStudent::where('class_id', $kelas->id)->pluck('student_id');

        $topSakit = Attendance::select('student_id', \DB::raw('count(*) as jumlah'))
            ->whereIn('student_id', $studentIds)
            ->where('status', 2)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('student_id')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get()
            ->map(fn($item) => (object)[
                'name' => $item->student->name,
                'jumlah' => $item->jumlah
            ]);

        $topIzin = Attendance::select('student_id', \DB::raw('count(*) as jumlah'))
            ->whereIn('student_id', $studentIds)
            ->where('status', 3)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('student_id')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get()
            ->map(fn($item) => (object)[
                'name' => $item->student->name,
                'jumlah' => $item->jumlah
            ]);

        $topAlpa = Attendance::select('student_id', \DB::raw('count(*) as jumlah'))
            ->whereIn('student_id', $studentIds)
            ->where('status', 4)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('student_id')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get()
            ->map(fn($item) => (object)[
                'name' => $item->student->name,
                'jumlah' => $item->jumlah
            ]);




        if ($attendanceCount >= $studentCount && $studentCount > 0) {
            // Sudah absen
            return view('user.already', compact('kelas', 'today', 'statistik', 'topSakit', 'topIzin', 'topAlpa'));
        }

        // Belum absen, tampilkan form
        return view('user.index', compact('kelas', 'students'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $studentIds = $request->input('student_ids');
        $classId = UserClass::where('user_id', Auth::id())->value('class_id');
        $date = now()->toDateString();

        foreach ($studentIds as $studentId) {
            $statusStr = $request->input("status_$studentId");

            if (!$statusStr) continue;

            $statusCode = match ($statusStr) {
                'hadir' => 1,
                'sakit' => 2,
                'izin'  => 3,
                'alpa'  => 4,
                default => null,
            };

            if ($statusCode) {
                \App\Models\Attendance::create([
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'date' => $date,
                    'status' => $statusCode,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
