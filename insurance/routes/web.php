<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CarController;

Route::resource('owners', OwnerController::class);
Route::resource('cars', CarController::class);

Route::get('/', function () {
    return redirect()->route('owners.index'); // Ana sayfa Owner index
});
