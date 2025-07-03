<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Attendance extends Seeder
{
    public function run(): void
    {
        $start = Carbon::create(2025, 1, 1);
        $end = Carbon::create(2025, 12, 31);

        $students = Student::all();

        foreach ($students as $student) {
            // Ambil class_id dari tabel pivot class_student
            $class = DB::table('class_student')->where('student_id', $student->id)->first();

            if (!$class) continue;

            $date = $start->copy();
            while ($date <= $end) {
                // Hanya hari Senin - Jumat
                if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                    DB::table('attendances')->insert([
                        'student_id' => $student->id,
                        'class_id' => $class->class_id,
                        'date' => $date->toDateString(),
                        'status' => rand(0, 3),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $date->addDay();
            }
        }
    }
}
