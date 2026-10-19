<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    // GET /blog — every published post, newest first, with optional ?q= search
    public function index(Request $request): View
    {
        return $this->listing($request);
    }

    // GET /blog/category/{slug} — published posts in one active category
    public function category(Request $request, string $slug): View
    {
        $category = BlogCategory::active()->where('slug', $slug)->firstOrFail();

        return $this->listing($request, category: $category);
    }

    // GET /blog/tag/{slug} — published posts carrying one active tag
    public function tag(Request $request, string $slug): View
    {
        $tag = BlogTag::active()->where('slug', $slug)->firstOrFail();

        return $this->listing($request, tag: $tag);
    }

    // GET /blog/{slug} — one published post plus a few from the same category
    public function show(string $slug): View
    {
        $blog = Blog::published()
            ->with(['category', 'tags' => fn ($q) => $q->active()])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Blog::published()
            ->with('category')
            ->whereKeyNot($blog->getKey())
            ->when($blog->category_id, fn (Builder $q) => $q->where('category_id', $blog->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.blog.show', [
            'blog' => $blog,
            'related' => $related,
        ]);
    }

    private function listing(Request $request, ?BlogCategory $category = null, ?BlogTag $tag = null): View
    {
        $search = trim((string) $request->query('q'));

        $blogs = Blog::published()
            ->with('category')
            ->when($category, fn (Builder $q) => $q->where('category_id', $category->id))
            ->when($tag, fn (Builder $q) => $q->whereHas('tags', fn (Builder $t) => $t->whereKey($tag->id)))
            ->when($search !== '', fn (Builder $q) => $q->where(fn (Builder $w) => $w
                ->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = BlogCategory::active()
            ->withCount(['blogs' => fn (Builder $q) => $q->published()])
            ->orderBy('name')
            ->get()
            ->filter(fn (BlogCategory $c) => $c->blogs_count > 0);

        return view('frontend.blog.index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'category' => $category,
            'tag' => $tag,
            'search' => $search,
        ]);
    }
}
