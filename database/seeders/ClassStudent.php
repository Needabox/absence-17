<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class ClassStudent extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();

        foreach ($students as $student) {
            $class = Classes::where('major_id', $student->major_id)->inRandomOrder()->first();

            if ($class) {
                DB::table('class_student')->insert([
                    'student_id' => $student->id,
                    'class_id' => $class->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
