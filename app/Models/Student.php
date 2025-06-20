<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'nis', 'nisn', 'major_id', 'status'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_student')->withTimestamps();
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
