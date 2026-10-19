<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Industry;
use App\Models\Partner;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    // GET /about — company story, values and live platform figures (modules, industries, partners, reviews)
    public function index(Request $request): View
    {
        // shared with the nav composers so the mega menus don't query them again
        $features = Feature::navigation();
        $industries = Industry::navigation();
        $request->attributes->set('navFeatures', $features);
        $request->attributes->set('navIndustries', $industries);

        $testimonials = Testimonial::active()->ordered()->get();

        return view('frontend.about.index', [
            'features' => $features,
            'industries' => $industries,
            'partners' => Partner::active()->featured()->ordered()->get(),
            'partnerCount' => Partner::active()->count(),
            'testimonials' => $testimonials->where('is_featured', true)->take(3)->values(),
            'testimonialCount' => $testimonials->count(),
            'averageRating' => $testimonials->isNotEmpty() ? round($testimonials->avg('rating'), 1) : null,
        ]);
    }
}
