<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classes extends Model
{
    protected $guarded = ['id'];

    protected $table = 'class'; // override table name

    public function homeroomTeacher()
    {
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }
    // Di model Classes.php
    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'class_id', 'student_id');
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke attendance (1 kelas punya banyak absensi)
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }
    public function major()
    {
        return $this->BelongsTo(Major::class);
    }

   
}
