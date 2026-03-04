<?php

use App\Http\Controllers\LecturersController;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/lecturers', [LecturersController::class,'index'])->name('lecturers.index');
Route::get('/lecturers/create', [LecturersController::class,'create'])->name('lecturers.create');
Route::post('/lecturers', [LecturersController::class,'store'])->name('lecturers.store');
Route::get('/lecturers/{lecturer}', [LecturersController::class,'edit'])->name('lecturers.edit');
Route::put('/lecturers/{lecturer}', [LecturersController::class,'update'])->name('lecturers.update');
Route::get('/lecturers/{lecturer}/delete', [LecturersController::class,'delete'])->name('lecturers.delete');
