<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassStudentController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::resource('users', UsersController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('class', ClassController::class);
    Route::resource('majors', MajorController::class);
    Route::resource('students', StudentController::class);

    Route::post('/class-student', [ClassStudentController::class, 'store'])->name('class-student.store');
    Route::delete('/class-student/{class}/{student}', [ClassStudentController::class, 'destroy'])->name('class-student.destroy');
});

// Kasir Routes
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::resource('class', ClassController::class);
    Route::resource('students', StudentController::class);

    Route::post('/class-student', [ClassStudentController::class, 'store'])->name('class-student.store');
    Route::delete('/class-student/{class}/{student}', [ClassStudentController::class, 'destroy'])->name('class-student.destroy');
});

Route::middleware(['auth', 'role:3'])->group(function () {
   
    Route::resource('absen', AttendanceController::class);

});
