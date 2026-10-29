<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Feature;
use App\Models\Industry;
use App\Services\PackageService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    // GET /sitemap.xml — every public, indexable page at its canonical address, read live so admin changes show up straight away
    public function __invoke(PackageService $packages): Response
    {
        $features = Feature::navigation();

        $urls = collect([
            ['loc' => route('home').'/'],
            ['loc' => route('features.index')],
        ])
            ->concat($features->map(fn (Feature $f) => ['loc' => route('features.show', $f->slug), 'lastmod' => $f->updated_at]))
            ->concat($features->filter(fn (Feature $f) => $f->sinhala_url)->map(fn (Feature $f) => ['loc' => $f->sinhala_url, 'lastmod' => $f->updated_at]))
            ->push(['loc' => route('industries.index')])
            ->concat(Industry::navigation()->map(fn (Industry $i) => ['loc' => route('industries.show', $i->slug), 'lastmod' => $i->updated_at]))
            ->push(['loc' => route('packages.index')])
            ->concat(array_map(fn (string $slug) => ['loc' => route('packages.show', $slug)], array_keys($packages->all())))
            ->push(['loc' => route('partners.index')], ['loc' => route('testimonials.index')], ['loc' => route('blog.index')])
            ->concat(Blog::published()->latest('published_at')->get(['slug', 'updated_at'])->map(fn (Blog $b) => ['loc' => route('blog.show', $b->slug), 'lastmod' => $b->updated_at]))
            ->push(['loc' => route('docs.index')])
            ->concat(array_map(fn (string $slug) => ['loc' => route('docs.show', $slug)], array_keys(config('docs.pages'))))
            ->push(['loc' => route('docs.api.index')])
            ->concat(collect(config('api-docs.groups'))->flatMap(fn (array $group) => array_keys($group['resources']))->map(fn (string $slug) => ['loc' => route('docs.api.show', $slug)]))
            ->push(['loc' => route('about')], ['loc' => route('contact')]);

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
