<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

// Language switch (English / Sinhala), remembered in a cookie
Route::get('/lang/{locale}', LocaleController::class)->where('locale', '[a-z]{2}')->name('locale.switch');

// XML sitemap for search engines (every public page, both languages' own addresses)
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Public website, shown in the visitor's picked language (static text in lang/{locale}, content in *_si columns)
Route::middleware('locale')->group(function () {
    // Home Page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Desktop POS setup for the visitor's OS
    Route::get('/download', [HomeController::class, 'download'])->name('download');

    // Features (one page per module, content in config/features.php)
    Route::get('/features', [FeatureController::class, 'index'])->name('features.index');
    Route::get('/features/{slug}', [FeatureController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('features.show');
    // Sinhala address of a feature page for search engines (/si/pos-system), listed in Feature::SINHALA_PATHS
    Route::get('/si/{path}', [FeatureController::class, 'showSinhala'])->where('path', '[a-z0-9-]+')->name('features.si');

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

    // Docs (desktop POS user guide, chapters in config/docs.php); /tutorial was the old guide address
    Route::get('/docs', [DocController::class, 'index'])->name('docs.index');
    // API reference (one page per resource, content in config/api-docs.php); registered before /docs/{slug}
    Route::get('/docs/api', [DocController::class, 'api'])->name('docs.api.index');
    Route::get('/docs/api/{slug}', [DocController::class, 'apiResource'])->where('slug', '[a-z0-9-]+')->name('docs.api.show');
    Route::get('/docs/{slug}', [DocController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('docs.show');
    Route::permanentRedirect('/tutorial', '/docs');

    // About Us (story and values, with live module / industry / partner figures)
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // Contact Us
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

    // Unknown addresses: routed here (instead of failing before any middleware) so the 404 page shows in the visitor's language
    Route::fallback(fn () => abort(404));
});
