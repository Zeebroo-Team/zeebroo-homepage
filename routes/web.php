<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Desktop POS setup for the visitor's OS
Route::get('/download', [HomeController::class, 'download'])->name('download');