<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CoverageTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// Authentication Routes
Auth::routes();

// Protected routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Owners
    Route::resource('owners', OwnerController::class);
    
    // Cars
    Route::resource('cars', CarController::class);
    
    // Policies
    Route::resource('policies', PolicyController::class);
    Route::post('policies/{policy}/activate', [PolicyController::class, 'activate'])->name('policies.activate');
    Route::post('policies/{policy}/cancel', [PolicyController::class, 'cancel'])->name('policies.cancel');
    
    // Claims
    Route::resource('claims', ClaimController::class);
    Route::post('claims/{claim}/approve', [ClaimController::class, 'approve'])->name('claims.approve');
    Route::post('claims/{claim}/deny', [ClaimController::class, 'deny'])->name('claims.deny');
    Route::post('claims/{claim}/pay', [ClaimController::class, 'markAsPaid'])->name('claims.pay');
    
    // Quotes
    Route::resource('quotes', QuoteController::class);
    Route::post('quotes/{quote}/convert', [QuoteController::class, 'convertToPolicy'])->name('quotes.convert');
    
    // Payments
    Route::resource('payments', PaymentController::class);
    Route::post('payments/{payment}/mark-paid', [PaymentController::class, 'markAsPaid'])->name('payments.mark-paid');
    
    // Drivers
    Route::resource('drivers', DriverController::class);
    
    // Coverage Types
    Route::resource('coverage-types', CoverageTypeController::class);
});
