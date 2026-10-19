<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');