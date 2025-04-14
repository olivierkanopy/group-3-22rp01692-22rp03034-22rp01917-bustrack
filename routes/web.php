<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Bus Management
    Route::resource('buses', BusController::class);
    
    // Route Management
    Route::resource('routes', RouteController::class);
    
    // Schedule Management
    Route::resource('schedules', ScheduleController::class);
    Route::patch('schedules/{schedule}/status', [ScheduleController::class, 'updateStatus'])
        ->name('schedules.update-status');
    
    // Stop Management
    Route::resource('stops', StopController::class);
    
    // Booking Management
    Route::get('bookings/create/{schedule}', [BookingController::class, 'create'])->name('bookings.create');
    Route::resource('bookings', BookingController::class)->except(['create']);
    Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('bookings/{booking}/confirm-payment', [BookingController::class, 'confirmPayment'])
        ->name('bookings.confirm-payment');
});
