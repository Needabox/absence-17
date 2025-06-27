<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function index()
    {
        $today = Carbon::today();
        $classes = Classes::all();

        foreach ($classes as $class) {
            $hasAttendance = Attendance::where('class_id', $class->id)
                ->where('date', $today)
                ->exists();
            $class->attendance_status = $hasAttendance ? 'Sudah Absen' : 'Belum Absen';
        }

        // === Chart Data ===
        $year = Carbon::now()->year;
        $statusMap = [1 => 'Hadir', 2 => 'Sakit', 3 => 'Izin', 4 => 'Alpa'];

        // Cek apakah ada data attendance untuk tahun ini
        $totalAttendance = Attendance::whereYear('date', $year)->count();
        \Log::info("Total attendance records for {$year}: " . $totalAttendance);

        // Query untuk mendapatkan data bulanan
        $monthly = DB::table('attendances')
            ->selectRaw('EXTRACT(MONTH FROM date) as month, status, COUNT(*) as total')
            ->whereYear('date', $year)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM date)'), 'status')
            ->orderBy('month')
            ->get();

        \Log::info('Monthly attendance data:', $monthly->toArray());

        // Inisialisasi chart data
        $chartData = [];
        foreach ($statusMap as $statusCode => $statusName) {
            $chartData[$statusName] = array_fill(0, 12, 0); // Index 0-11 untuk Jan-Dec
        }

        // Isi data berdasarkan query result
        foreach ($monthly as $row) {
            $statusName = $statusMap[$row->status] ?? null;
            if ($statusName && isset($chartData[$statusName])) {
                $monthIndex = (int)$row->month - 1; // Convert 1-12 to 0-11
                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $chartData[$statusName][$monthIndex] = (int)$row->total;
                }
            }
        }

        \Log::info('Final chart data:', $chartData);

        // Jika tidak ada data, buat data dummy untuk testing
        if ($totalAttendance == 0) {
            \Log::info('No attendance data found, creating dummy data for testing');
            $chartData = [
                'Hadir' => [10, 15, 20, 18, 22, 25, 30, 28, 26, 24, 20, 18],
                'Sakit' => [2, 3, 1, 2, 1, 2, 3, 2, 1, 2, 3, 2],
                'Izin' => [1, 2, 2, 1, 3, 1, 2, 1, 2, 1, 2, 1],
                'Alpa' => [0, 1, 0, 1, 0, 0, 1, 0, 1, 0, 0, 1]
            ];
        }

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        return view('admin.attendance.dashboard', compact('classes', 'today', 'chartData', 'labels', 'year'));
    }
}
