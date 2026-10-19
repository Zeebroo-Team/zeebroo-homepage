<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    // GET /partners — every active partner and client, grouped by category; ?category={slug} shows one category
    public function index(Request $request): View
    {
        $partners = Partner::active()->with('category')->ordered()->get();

        $categories = PartnerCategory::active()
            ->ordered()
            ->get()
            ->each(fn (PartnerCategory $c) => $c->setRelation('partners', $partners->where('partner_category_id', $c->id)->values()))
            ->filter(fn (PartnerCategory $c) => $c->partners->isNotEmpty())
            ->values();

        $category = null;
        if ($request->filled('category')) {
            $category = $categories->firstWhere('slug', (string) $request->query('category'));
            abort_if($category === null, 404);
        }

        return view('frontend.partners.index', [
            'categories' => $categories,
            'category' => $category,
            'uncategorised' => $partners->whereNull('partner_category_id')->values(),
            'partnerCount' => $partners->count(),
            'locationCount' => $partners->pluck('location')->filter()->unique()->count(),
        ]);
    }
}
