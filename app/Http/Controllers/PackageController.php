<?php

namespace App\Http\Controllers;

use App\Services\PackageService;
use Illuminate\View\View;

class PackageController extends Controller
{
    // GET /packages — every subscription package, plus a side-by-side comparison
    public function index(PackageService $packages): View
    {
        return view('frontend.packages.index', [
            'packages' => $packages->all(),
            'features' => $packages->allFeatures(),
        ]);
    }

    // GET /packages/{slug} — one package; previous/next walk the same order as the mega menu
    public function show(string $slug, PackageService $packages): View
    {
        $all = $packages->all();
        abort_unless(isset($all[$slug]), 404);

        $package = $all[$slug];
        $slugs = array_keys($all);
        $i = array_search($slug, $slugs, true);
        $prev = $slugs[($i - 1 + count($slugs)) % count($slugs)];
        $next = $slugs[($i + 1) % count($slugs)];

        return view('frontend.packages.show', [
            'package' => $package,
            // features other packages unlock that this one doesn't, as an upgrade hint
            'missing' => array_diff_key($packages->allFeatures(), $package['features']),
            'prev'    => $prev !== $slug ? $all[$prev] : null,
            'next'    => $next !== $slug ? $all[$next] : null,
        ]);
    }
}
