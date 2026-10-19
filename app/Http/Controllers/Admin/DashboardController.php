<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // GET /admin — counts and the latest posts
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'Posts' => Blog::count(),
                'Published' => Blog::published()->count(),
                'Categories' => BlogCategory::count(),
                'Tags' => BlogTag::count(),
            ],
            'latest' => Blog::with('category')->latest()->take(5)->get(),
        ]);
    }
}
