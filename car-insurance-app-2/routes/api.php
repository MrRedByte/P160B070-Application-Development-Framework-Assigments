<?php

use App\Http\Controllers\API\AuthAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CarsAPIController;
use App\Http\Controllers\API\OwnersAPIController;

Route::post('/login', [AuthAPIController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthAPIController::class, 'logout']);

    Route::get('/owners', [OwnersAPIController::class, 'index']);
    Route::get('/owners/{id}', [OwnersAPIController::class, 'show']);
    Route::post('/owners', [OwnersAPIController::class, 'store']);
    Route::put('/owners/{id}', [OwnersAPIController::class, 'update']);
    Route::delete('/owners/{id}', [OwnersAPIController::class, 'destroy']);

    Route::resource('cars', CarsAPIController::class)
        ->only('index', 'show', 'store', 'update', 'destroy');

});
