<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndustryRequest;
use App\Models\Feature;
use App\Models\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class IndustryController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view industries', only: ['index']),
            new Middleware('permission:create industries', only: ['create', 'store']),
            new Middleware('permission:edit industries', only: ['edit', 'update']),
            new Middleware('permission:delete industries', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $industries = Industry::withCount('modules')
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->ordered()
            ->paginate(25)
            ->withQueryString();

        return view('admin.industries.index', [
            'industries' => $industries,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.industries.create', $this->formData(new Industry([
            'icon' => 'fa-briefcase',
            'is_active' => true,
            'sort_order' => (int) Industry::max('sort_order') + 1,
        ])));
    }

    public function store(IndustryRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('scene')) {
            $data['scene_path'] = $request->file('scene')->store('industries', 'public');
        }

        $industry = Industry::create($data);
        $this->syncModules($industry, $request);

        return redirect()->route('admin.industries.index')->with('status', 'Industry created.');
    }

    public function edit(Industry $industry): View
    {
        return view('admin.industries.edit', $this->formData($industry->load('modules')));
    }

    public function update(IndustryRequest $request, Industry $industry): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('scene') || $request->boolean('remove_scene')) {
            if ($industry->scene_path) {
                Storage::disk('public')->delete($industry->scene_path);
            }
            $data['scene_path'] = $request->hasFile('scene') ? $request->file('scene')->store('industries', 'public') : null;
        }

        $industry->update($data);
        $this->syncModules($industry, $request);

        return redirect()->route('admin.industries.index')->with('status', 'Industry updated.');
    }

    public function destroy(Industry $industry): RedirectResponse
    {
        if ($industry->scene_path) {
            Storage::disk('public')->delete($industry->scene_path);
        }

        $industry->delete();

        return redirect()->route('admin.industries.index')->with('status', 'Industry deleted.');
    }

    /**
     * Validated columns of the industries table.
     *
     * @return array<string, mixed>
     */
    private function payload(IndustryRequest $request): array
    {
        return collect($request->validated())->except(['modules', 'scene', 'remove_scene'])->all();
    }

    /**
     * Keeps the recommended modules in the order they are listed on the form.
     */
    private function syncModules(Industry $industry, IndustryRequest $request): void
    {
        $industry->modules()->sync(
            collect($request->validated('modules', []))
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->mapWithKeys(fn (int $id, int $i) => [$id => ['sort_order' => $i]])
        );
    }

    /**
     * @return array{industry: Industry, features: Collection<int, Feature>}
     */
    private function formData(Industry $industry): array
    {
        return [
            'industry' => $industry,
            'features' => Feature::ordered()->get(['id', 'title', 'icon', 'is_active']),
        ];
    }
}
