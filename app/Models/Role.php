<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public const ADMIN = 1;
    public const GURU = 2;
    public const KETUA_KELAS = 3;
}
