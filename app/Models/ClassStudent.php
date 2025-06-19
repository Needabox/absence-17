<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassStudent extends Pivot
{
    protected $table = 'class_student';

    protected $fillable = [
        'student_id',
        'class_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
