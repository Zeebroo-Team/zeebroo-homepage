<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\View\View;

class IndustryController extends Controller
{
    // GET /industries — every active industry Zeebroo is set up for
    public function index(): View
    {
        return view('frontend.industries.index', ['industries' => Industry::navigation()]);
    }

    // GET /industries/{slug} — one active industry page; previous/next walk the same order as the mega menu
    public function show(string $slug): View
    {
        $industries = Industry::navigation()->values();
        $i = $industries->search(fn (Industry $industry) => $industry->slug === $slug);
        abort_if($i === false, 404);

        $industry = $industries[$i]->load(['modules' => fn ($q) => $q->active()]);

        return view('frontend.industries.show', [
            'industry' => $industry,
            'modules' => $industry->modules,
            'prev' => $industries[($i - 1 + $industries->count()) % $industries->count()],
            'next' => $industries[($i + 1) % $industries->count()],
        ]);
    }
}
