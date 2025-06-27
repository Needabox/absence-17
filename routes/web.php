<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassStudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('cms')->group(function () {
    Route::middleware(['auth', 'role:' . App\Models\Role::ADMIN])->group(function () {
        Route::resource('users', UsersController::class);
        Route::resource('roles', RolesController::class);
        Route::resource('class', ClassController::class);
        Route::resource('majors', MajorController::class);
        Route::resource('students', StudentController::class);

        Route::post('/class-student', [ClassStudentController::class, 'store'])->name('class-student.store');
        Route::delete('/class-student/{class}/{student}', [ClassStudentController::class, 'destroy'])->name('class-student.destroy');
        Route::post('/import-student-class', [ClassStudentController::class, 'import'])->name('import.student-class');
    });

    // Guru Routes
    Route::middleware(['auth', 'role:1,2'])->group(function () {
        Route::resource('class', ClassController::class);
        Route::resource('students', StudentController::class);

        Route::post('/class-student', [ClassStudentController::class, 'store'])->name('class-student.store');
        Route::delete('/class-student/{class}/{student}', [ClassStudentController::class, 'destroy'])->name('class-student.destroy');
        route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/import-student-class', [ClassStudentController::class, 'import'])->name('import.student-class');

    });
});
Route::middleware(['auth', 'role:' . App\Models\Role::KETUA_KELAS])->group(function () {
    Route::resource('absen', AttendanceController::class);
});
