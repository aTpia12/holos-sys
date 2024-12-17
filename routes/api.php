<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitialReserveController;
use App\Http\Controllers\EventsReminderController;

Route::post('initial-reserve', InitialReserveController::class)->name('initial-reserve');
Route::get('reminder-events', EventsReminderController::class)->name('reminder-events');


