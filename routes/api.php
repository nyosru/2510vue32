<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

use App\Http\Controllers\BookingController;

Route::get('/slots', [BookingController::class, 'availableSlots']);
Route::post('/bookings', [BookingController::class, 'store']);
