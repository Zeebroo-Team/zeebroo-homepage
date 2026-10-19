<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class IndustryController extends Controller
{
    // GET /industries — every industry Zeebroo is set up for
    public function index(): View
    {
        return view('frontend.industries.index', ['industries' => config('industries')]);
    }

    // GET /industries/{slug} — one industry page; previous/next walk the same order as the mega menu
    public function show(string $slug): View
    {
        $industries = config('industries');
        abort_unless(isset($industries[$slug]), 404);

        $slugs = array_keys($industries);
        $i = array_search($slug, $slugs, true);
        $prev = $slugs[($i - 1 + count($slugs)) % count($slugs)];
        $next = $slugs[($i + 1) % count($slugs)];
        $industry = $industries[$slug];

        return view('frontend.industries.show', [
            'slug'     => $slug,
            'industry' => $industry,
            'modules'  => array_intersect_key(config('features'), array_flip($industry['modules'])),
            'prev'     => ['slug' => $prev] + $industries[$prev],
            'next'     => ['slug' => $next] + $industries[$next],
        ]);
    }
}
