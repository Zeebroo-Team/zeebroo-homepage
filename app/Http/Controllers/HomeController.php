<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Testimonial;
use App\Services\PackageService;
use App\Services\PosReleaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, PosReleaseService $releases, PackageService $packages)
    {
        return view('frontend.home.index', [
            'homePackages' => $packages->all(),
            'posRelease' => $releases->latest(),
            'posDetectedOs' => $releases->pickFor($request->userAgent() ?? ''),
            'featuredPartners' => Partner::active()->featured()->ordered()->get(),
            'featuredTestimonials' => Testimonial::active()->featured()->ordered()->get(),
        ]);
    }

    // /download — straight to the setup file for the visitor's OS (?os= overrides), else the download section
    public function download(Request $request, PosReleaseService $releases): RedirectResponse
    {
        $downloads = $releases->downloads();
        $os = $request->query('os');
        $os = is_string($os) && isset($downloads[$os]) ? $os : $releases->pickFor($request->userAgent() ?? '');

        return $os
            ? redirect()->away($downloads[$os])
            : redirect()->to(route('home').'#download');
    }
}
