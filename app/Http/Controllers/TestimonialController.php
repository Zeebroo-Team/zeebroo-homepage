<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    // GET /testimonials — every active testimonial, in admin order
    public function index(): View
    {
        $testimonials = Testimonial::active()->ordered()->get();

        return view('frontend.testimonials.index', [
            'testimonials' => $testimonials,
            'averageRating' => $testimonials->isNotEmpty() ? round($testimonials->avg('rating'), 1) : null,
        ]);
    }
}
