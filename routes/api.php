<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitialReserveController;

Route::post('initial-reserve', InitialReserveController::class)->name('initial-reserve');


