<?php

namespace App\Providers;

use App\Models\Feature;
use App\Models\Industry;
use App\Models\User;
use App\Services\LocalizedViewFinder;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Sinhala copies of views (hero_si.blade.php) are picked automatically when the website is in Sinhala
        $this->app->bind('view.finder', fn ($app) => new LocalizedViewFinder($app['files'], $app['config']['view.paths']));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(fn (User $user): ?bool => $user->hasRole('super-admin') ? true : null);

        Paginator::defaultView('pagination.zeebroo');

        // Active features for the Modules mega menu, footer and home page, loaded once per request
        ViewFacade::composer(
            ['frontend.components.header', 'frontend.components.footer', 'frontend.home.modules'],
            function (View $view): void {
                $attributes = request()->attributes;

                if (! $attributes->has('navFeatures')) {
                    $attributes->set('navFeatures', Feature::navigation());
                }

                $view->with('navFeatures', $attributes->get('navFeatures'));
            },
        );

        // Active industries for the Industries mega menu and the industries grid, loaded once per request
        ViewFacade::composer(
            ['frontend.components.header', 'frontend.industries.partials.grid'],
            function (View $view): void {
                $attributes = request()->attributes;

                if (! $attributes->has('navIndustries')) {
                    $attributes->set('navIndustries', Industry::navigation());
                }

                $view->with('navIndustries', $attributes->get('navIndustries'));
            },
        );
    }
}
