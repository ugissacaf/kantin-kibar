<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Menu routes - public view, admin only for create/update/delete
    Route::resource('menus', MenuController::class);
    Route::get('/menu-available', [MenuController::class, 'available'])->name('menus.available');

    // Order routes
    Route::resource('orders', OrderController::class);
    Route::post('/orders/pre-order', [OrderController::class, 'preOrder'])->name('orders.pre-order');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
