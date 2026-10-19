<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view blogs', only: ['index']),
            new Middleware('permission:create blogs', only: ['create', 'store']),
            new Middleware('permission:edit blogs', only: ['edit', 'update']),
            new Middleware('permission:delete blogs', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $categoryId = $request->integer('category') ?: null;

        $blogs = Blog::with('category')
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog.posts.index', [
            'blogs' => $blogs,
            'search' => $search,
            'categoryId' => $categoryId,
            'categories' => BlogCategory::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.blog.posts.create', $this->formData(new Blog([
            'is_active' => $request->user()->can('publish blogs'),
            'author_name' => $request->user()->name,
            'published_at' => now(),
        ])));
    }

    public function store(BlogRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create($data);
        $blog->tags()->sync($request->validated('tags', []));

        return redirect()->route('admin.blog.posts.index')->with('status', 'Post created.');
    }

    public function edit(Blog $blog): View
    {
        return view('admin.blog.posts.edit', $this->formData($blog->load('tags')));
    }

    public function update(BlogRequest $request, Blog $blog): RedirectResponse
    {
        $data = $this->payload($request, $blog);

        if ($request->hasFile('image') || $request->boolean('remove_image')) {
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $data['image_path'] = $request->hasFile('image') ? $request->file('image')->store('blogs', 'public') : null;
        }

        $blog->update($data);
        $blog->tags()->sync($request->validated('tags', []));

        return redirect()->route('admin.blog.posts.index')->with('status', 'Post updated.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }

        $blog->delete();

        return redirect()->route('admin.blog.posts.index')->with('status', 'Post deleted.');
    }

    /**
     * Validated columns; users without "publish blogs" cannot change visibility or the publish date.
     *
     * @return array<string, mixed>
     */
    private function payload(BlogRequest $request, ?Blog $blog = null): array
    {
        $data = collect($request->validated())->except(['tags', 'image', 'remove_image'])->all();

        if ($request->user()->cannot('publish blogs')) {
            unset($data['is_active'], $data['published_at']);

            if (! $blog) {
                $data['is_active'] = false;
            }
        }

        return $data;
    }

    /**
     * @return array{blog: Blog, categories: Collection<int, string>, tags: Collection<int, string>}
     */
    private function formData(Blog $blog): array
    {
        return [
            'blog' => $blog,
            'categories' => BlogCategory::orderBy('name')->pluck('name', 'id'),
            'tags' => BlogTag::orderBy('name')->pluck('name', 'id'),
        ];
    }
}
