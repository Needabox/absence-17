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

    // ⬇️ Ini cukup untuk membaca heading dari baris ke-3
    public function headingRow(): int
    {
        return 3;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Pastikan field ada
            if (!isset($row['nis']) || !isset($row['name'])) continue;

            $nis = trim((string) $row['nis']);
            $name = trim((string) $row['name']);

            // Skip baris kosong
            if ($nis === '' || $name === '') continue;

            // Cek apakah siswa sudah ada
            $student = Student::where('nis', $nis)->first();

            if ($student) {
                // Sudah ada, tambahkan ke class_student
                DB::table('class_student')->updateOrInsert([
                    'student_id' => $student->id,
                    'class_id'   => $this->class_id,
                ], [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->duplicates[] = $nis;
                continue;
            }

            // Siswa baru
            $gender = strtoupper(trim($row['gender'])) === 'L' ? 0 : 1;

            $student = Student::create([
                'name'      => $name,
                'gender'    => $gender,
                'nis'       => $nis,
                'nisn'      => $row['nisn'],
                'status'    => 1,
                'major_id'  => $this->major_id,
            ]);

            DB::table('class_student')->insert([
                'student_id' => $student->id,
                'class_id'   => $this->class_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
