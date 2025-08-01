<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relasi ke students
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
}
