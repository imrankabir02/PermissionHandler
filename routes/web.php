<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::view('/', 'welcome');

Route::view('users', '')
    ->middleware(['auth', 'verified'])
    ->name('users');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Our resource routes
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class)->middleware(['can:product-list']);
    Route::resource('products', ProductController::class);
});

// routes/web.php
// Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', Logout::class)->name('logout');

require __DIR__ . '/auth.php';
