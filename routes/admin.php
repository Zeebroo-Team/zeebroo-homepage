<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Blog\BlogCategoryController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\Blog\BlogTagController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Docs\DocGroupController;
use App\Http\Controllers\Admin\Docs\DocImageController;
use App\Http\Controllers\Admin\Docs\DocPageController;
use App\Http\Controllers\Admin\Docs\DocTaskController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PartnerCategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SeoPageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Models\SeoPage;
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

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::resource('categories', BlogCategoryController::class)->except('show');
        Route::resource('tags', BlogTagController::class)->except('show');
        Route::resource('posts', BlogController::class)->except('show')->parameters(['posts' => 'blog']);
    });

    Route::resource('features', FeatureController::class)->except('show');
    Route::resource('industries', IndustryController::class)->except('show');
    Route::resource('partner-categories', PartnerCategoryController::class)->except('show');
    Route::patch('partners/{partner}/featured', [PartnerController::class, 'toggleFeatured'])->name('partners.featured');
    Route::resource('partners', PartnerController::class)->except('show');
    Route::resource('testimonials', TestimonialController::class)->except('show');
    Route::resource('enquiries', EnquiryController::class)->only(['index', 'show', 'update', 'destroy']);

    // Docs: the user guide at /docs (pages with their sections, sidebar groups, common tasks)
    Route::prefix('docs')->name('docs.')->group(function () {
        Route::resource('pages', DocPageController::class)->except('show');
        Route::resource('groups', DocGroupController::class)->except('show');
        Route::resource('tasks', DocTaskController::class)->except('show');
        Route::post('images', [DocImageController::class, 'store'])->name('images.store');
    });

    // SEO: title, description and share image of the fixed website pages (SeoPage::PAGES)
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::resource('pages', SeoPageController::class)->only(['index', 'edit', 'update'])
            ->where(['page' => implode('|', array_keys(SeoPage::PAGES))]);
    });
});
