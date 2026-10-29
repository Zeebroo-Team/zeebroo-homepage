<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Feature;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class FeatureController extends Controller
{
    // GET /features — every active module, core first then the rest of the suite
    public function index(): View
    {
        $features = Feature::navigation();

        return view('frontend.features.index', [
            'core' => $features->where('group', 'core'),
            'suite' => $features->where('group', 'suite'),
        ]);
    }

    // GET /features/{slug} — one active feature page; previous/next walk the same order as the mega menu
    public function show(string $slug): View
    {
        return $this->page($slug);
    }

    // GET /si/{path} — a feature's own Sinhala address (Feature::SINHALA_PATHS), always in Sinhala so search engines can index it
    public function showSinhala(string $path): View
    {
        $slug = array_search($path, Feature::SINHALA_PATHS, true);
        abort_if($slug === false, 404);

        app()->setLocale('si');
        Carbon::setLocale('si');

        // keep the rest of the visit in Sinhala too
        Cookie::queue(Cookie::forever(SetLocale::COOKIE, 'si'));

        return $this->page($slug);
    }

    private function page(string $slug): View
    {
        $features = Feature::navigation()->values();
        $i = $features->search(fn (Feature $f) => $f->slug === $slug);
        abort_if($i === false, 404);

        $feature = $features[$i]->load([
            'screenshots',
            'related' => fn ($q) => $q->active(),
        ]);

        return view('frontend.features.show', [
            'feature' => $feature,
            'related' => $feature->related,
            'prev' => $features[($i - 1 + $features->count()) % $features->count()],
            'next' => $features[($i + 1) % $features->count()],
        ]);
    }
}
