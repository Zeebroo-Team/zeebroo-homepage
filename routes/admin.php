<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Blog\BlogCategoryController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\Blog\BlogTagController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\IndustryController;
use Illuminate\Support\Facades\Route;

// Admin (loaded from bootstrap/app.php with the "web" middleware, /admin prefix and "admin." names)

// Sign in / out
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

// Everything else needs a signed-in user; each controller checks its own Spatie permissions
Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::resource('categories', BlogCategoryController::class)->except('show');
        Route::resource('tags', BlogTagController::class)->except('show');
        Route::resource('posts', BlogController::class)->except('show')->parameters(['posts' => 'blog']);
    });

    Route::resource('features', FeatureController::class)->except('show');
    Route::resource('industries', IndustryController::class)->except('show');
});
