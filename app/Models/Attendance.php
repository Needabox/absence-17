<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'student_id',
        'class_id',
        'date',
        'status',
    ];

    // Relasi ke student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // Fungsi bantu untuk status dalam teks
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            1 => 'Hadir',
            2 => 'Sakit',
            3 => 'Izin',
            4 => 'Alpa',
            default => 'Tidak Diketahui',
        };
    }
}
