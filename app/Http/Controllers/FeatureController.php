<?php

namespace App\Http\Controllers;

use App\Models\Feature;
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
