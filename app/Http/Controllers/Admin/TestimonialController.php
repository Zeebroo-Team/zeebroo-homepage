<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view testimonials', only: ['index']),
            new Middleware('permission:create testimonials', only: ['create', 'store']),
            new Middleware('permission:edit testimonials', only: ['edit', 'update']),
            new Middleware('permission:delete testimonials', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $testimonials = Testimonial::query()
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', "%{$search}%")->orWhere('position', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(25)
            ->withQueryString();

        return view('admin.testimonials.index', [
            'testimonials' => $testimonials,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.testimonials.create', ['testimonial' => new Testimonial([
            'rating' => Testimonial::MAX_RATING,
            'is_active' => true,
            'sort_order' => (int) Testimonial::max('sort_order') + 1,
        ])]);
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', ['testimonial' => $testimonial]);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('image') || $request->boolean('remove_image')) {
            if ($testimonial->image_path) {
                Storage::disk('public')->delete($testimonial->image_path);
            }
            $data['image_path'] = $request->hasFile('image') ? $request->file('image')->store('testimonials', 'public') : null;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->image_path) {
            Storage::disk('public')->delete($testimonial->image_path);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial deleted.');
    }

    /**
     * Validated columns of the testimonials table.
     *
     * @return array<string, mixed>
     */
    private function payload(TestimonialRequest $request): array
    {
        return collect($request->validated())->except(['image', 'remove_image'])->all();
    }
}
