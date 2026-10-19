<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeatureController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Desktop POS setup for the visitor's OS
Route::get('/download', [HomeController::class, 'download'])->name('download');

// Features (one page per module, content in config/features.php)
Route::get('/features', [FeatureController::class, 'index'])->name('features.index');
Route::get('/features/{slug}', [FeatureController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('features.show');

// Contact Us
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');
