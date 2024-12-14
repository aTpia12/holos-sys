<?php

use App\Livewire\Sections\Calendar;
use App\Livewire\Sections\Events;
use Illuminate\Support\Facades\Route;
use App\Livewire\Sections\Category;
use App\Livewire\Sections\Pos;
use App\Livewire\Sections\Product;
use App\Livewire\Sections\Sale;
use App\Livewire\Sections\User;
use App\Livewire\Sections\Ticket;
use App\Livewire\Sections\ProductComponent;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('calendar', Calendar::class)->name('calendar');
Route::get('categorias', Category::class)->name('categorias');
Route::get('eventos/{userId}', Events::class)->name('eventos');
Route::get('pos', Pos::class)->name('pos');
Route::get('productos', Product::class)->name('productos');
Route::get('sales', Sale::class)->name('sales');
Route::get('users', User::class)->name('users');
Route::get('ticket/{id?}', Ticket::class)->name('ticket');
Route::get('inventario', ProductComponent::class)->name('inventario');

require __DIR__.'/auth.php';
