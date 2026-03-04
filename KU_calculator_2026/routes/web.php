<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\CalculatorController::class, 'index'])->name('calculator');

Route::post('/result',[\App\Http\Controllers\CalculatorController::class,'result'] )->name('result');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
