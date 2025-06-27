<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection, WithHeadingRow
{
    public $duplicates = [];
    protected $major_id;
    protected $class_id;

    public function __construct($major_id, $class_id)
    {
        $this->major_id = $major_id;
        $this->class_id = $class_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $nis = $row['nis'];

            $exists = Student::where('nis', $nis)->exists();

            if ($exists) {
                $this->duplicates[] = $nis;
                continue;
            }

            // Konversi gender: 'L' => 0, 'P' => 1
            $gender = strtoupper(trim($row['gender'])) === 'L' ? 0 : 1;

            $student = Student::create([
                'name'      => $row['name'],
                'gender'    => $gender,
                'nis'       => $row['nis'],
                'nisn'      => $row['nisn'],
                'status'    => 1,
                'major_id'  => $this->major_id,
            ]);

            DB::table('class_student')->insert([
                'student_id' => $student->id,
                'class_id'   => $this->class_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
