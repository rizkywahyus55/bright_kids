<?php

use App\Http\Controllers\PaymentController;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Midtrans Webhook Callback
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification']);

// Dynamic active schedules for AJAX
Route::get('/jadwal-aktif', function() {
    $schedules = Schedule::where('is_active', true)->orderBy('start_time')->get();
    return response()->json($schedules);
});
