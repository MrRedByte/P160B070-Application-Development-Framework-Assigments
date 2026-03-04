<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BmiController;

// Anasayfa → form
Route::get('/', [BmiController::class, 'index']);

// Form gönderimi → BMI hesaplama
Route::post('/calculate', [BmiController::class, 'calculate'])->name('bmi.calculate');
