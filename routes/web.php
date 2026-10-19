<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\PackageController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Desktop POS setup for the visitor's OS
Route::get('/download', [HomeController::class, 'download'])->name('download');

// Features (one page per module, content in config/features.php)
Route::get('/features', [FeatureController::class, 'index'])->name('features.index');
Route::get('/features/{slug}', [FeatureController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('features.show');

// Industries (one page per industry, content in config/industries.php)
Route::get('/industries', [IndustryController::class, 'index'])->name('industries.index');
Route::get('/industries/{slug}', [IndustryController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('industries.show');

// Packages (pricing, read live from the platform's Admin → Package Management)
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('packages.show');

// Contact Us
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');
