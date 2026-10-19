<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class BlogCategoryController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view blog categories', only: ['index']),
            new Middleware('permission:create blog categories', only: ['create', 'store']),
            new Middleware('permission:edit blog categories', only: ['edit', 'update']),
            new Middleware('permission:delete blog categories', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $categories = BlogCategory::withCount('blogs')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog.categories.index', compact('categories', 'search'));
    }

    public function create(): View
    {
        return view('admin.blog.categories.create', ['category' => new BlogCategory(['is_active' => true])]);
    }

    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        BlogCategory::create($request->validated());

        return redirect()->route('admin.blog.categories.index')->with('status', 'Category created.');
    }

    public function edit(BlogCategory $category): View
    {
        return view('admin.blog.categories.edit', compact('category'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('admin.blog.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(BlogCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.blog.categories.index')->with('status', 'Category deleted. Its posts are now uncategorised.');
    }
}
