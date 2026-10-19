<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

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

// Partners & clients (managed in /admin)
Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');

// Testimonials (managed in /admin)
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

// Packages (pricing, read live from the platform's Admin → Package Management)
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('packages.show');

// Blog (posts, categories and tags managed in /admin)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->where('slug', '[a-z0-9-]+')->name('blog.category');
Route::get('/blog/tag/{slug}', [BlogController::class, 'tag'])->where('slug', '[a-z0-9-]+')->name('blog.tag');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('blog.show');

// About Us (story and values, with live module / industry / partner figures)
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Contact Us
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');
