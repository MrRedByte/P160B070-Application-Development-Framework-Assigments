<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/setLanguage/{lang}', [App\Http\Controllers\LanguageController::class, 'setLanguage'])->name('setLanguage');
Route::get('/', [App\Http\Controllers\OwnerController::class, 'index'])->name('insurance');

Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/owners/create', [OwnerController::class, 'create'])->name('owners.create');
    Route::post('/owners', [OwnerController::class, 'store'])->name('owners.store');
    Route::get('/owners/{owner}/edit', [OwnerController::class, 'edit'])->name('owners.edit');
    Route::put('/owners/{owner}', [OwnerController::class, 'update'])->name('owners.update');
    Route::delete('/owner/{owner}', [OwnerController::class, 'destroy'])->name('owners.destroy');
});


Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::post('/cars/{id}/photos', [CarController::class, 'uploadPhotos'])->name('cars.photos.upload');
    Route::delete('/photos/{id}', [CarController::class, 'deletePhoto'])->name('photos.delete');
});
