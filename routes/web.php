<?php

use App\Http\Controllers\Admin\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('users', [UsersController::class, 'index'])->name('users.index');
Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('users/store', [UsersController::class, 'store'])->name('users.store');
Route::get('users/{id}', [UsersController::class, 'show'])->name('users.show');
Route::get('users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

Route::get('roles', [RolesController::class,  'index'])->name('roles.index');
Route::get('roles/create', [RolesController::class,  'create'])->name('roles.create');
Route::post('roles/store', [RolesController::class,  'store'])->name('roles.store');
Route::get('roles/{id}/edit', [RolesController::class,  'edit'])->name('roles.edit');
Route::put('roles/{id}', [RolesController::class,  'update'])->name('roles.update');
Route::delete('roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');

