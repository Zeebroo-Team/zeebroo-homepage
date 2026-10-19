<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FeatureController extends Controller
{
    // GET /features — every module, core first then the rest of the suite
    public function index(): View
    {
        $features = config('features');

        return view('frontend.features.index', [
            'core'  => array_filter($features, fn ($f) => $f['group'] === 'core'),
            'suite' => array_filter($features, fn ($f) => $f['group'] === 'suite'),
        ]);
    }

    // GET /features/{slug} — one feature page; previous/next walk the same order as the mega menu
    public function show(string $slug): View
    {
        $features = config('features');
        abort_unless(isset($features[$slug]), 404);

        $slugs = array_keys($features);
        $i = array_search($slug, $slugs, true);
        $prev = $slugs[($i - 1 + count($slugs)) % count($slugs)];
        $next = $slugs[($i + 1) % count($slugs)];

        return view('frontend.features.show', [
            'slug'    => $slug,
            'feature' => $features[$slug],
            'related' => array_intersect_key($features, array_flip($features[$slug]['related'])),
            'prev'    => ['slug' => $prev] + $features[$prev],
            'next'    => ['slug' => $next] + $features[$next],
        ]);
    }
}
