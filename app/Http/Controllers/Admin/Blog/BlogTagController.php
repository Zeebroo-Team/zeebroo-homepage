<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\BlogTagRequest;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class BlogTagController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view blog tags', only: ['index']),
            new Middleware('permission:create blog tags', only: ['create', 'store']),
            new Middleware('permission:edit blog tags', only: ['edit', 'update']),
            new Middleware('permission:delete blog tags', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $tags = BlogTag::withCount('blogs')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog.tags.index', compact('tags', 'search'));
    }

    public function create(): View
    {
        return view('admin.blog.tags.create', ['tag' => new BlogTag(['is_active' => true])]);
    }

    public function store(BlogTagRequest $request): RedirectResponse
    {
        BlogTag::create($request->validated());

        return redirect()->route('admin.blog.tags.index')->with('status', 'Tag created.');
    }

    public function edit(BlogTag $tag): View
    {
        return view('admin.blog.tags.edit', compact('tag'));
    }

    public function update(BlogTagRequest $request, BlogTag $tag): RedirectResponse
    {
        $tag->update($request->validated());

        return redirect()->route('admin.blog.tags.index')->with('status', 'Tag updated.');
    }

    public function destroy(BlogTag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('admin.blog.tags.index')->with('status', 'Tag deleted.');
    }
}
