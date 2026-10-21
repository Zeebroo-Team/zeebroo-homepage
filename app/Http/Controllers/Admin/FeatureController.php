<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeatureRequest;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FeatureController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view features', only: ['index']),
            new Middleware('permission:create features', only: ['create', 'store']),
            new Middleware('permission:edit features', only: ['edit', 'update']),
            new Middleware('permission:delete features', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $group = array_key_exists((string) $request->query('group'), Feature::GROUPS) ? (string) $request->query('group') : null;

        $features = Feature::withCount('screenshots')
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($group, fn ($q) => $q->where('group', $group))
            ->ordered()
            ->paginate(25)
            ->withQueryString();

        return view('admin.features.index', [
            'features' => $features,
            'search' => $search,
            'group' => $group,
        ]);
    }

    public function create(): View
    {
        return view('admin.features.create', $this->formData(new Feature([
            'icon' => 'fa-puzzle-piece',
            'group' => 'suite',
            'is_active' => true,
            'sort_order' => (int) Feature::max('sort_order') + 1,
        ])));
    }

    public function store(FeatureRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        foreach (['spot', 'scene'] as $image) {
            if ($request->hasFile($image)) {
                $data["{$image}_path"] = $request->file($image)->store('features', 'public');
            }
        }

        $feature = Feature::create($data);
        $this->syncRelated($feature, $request);
        $this->syncScreenshots($feature, $request);

        return redirect()->route('admin.features.index')->with('status', 'Feature created.');
    }

    public function edit(Feature $feature): View
    {
        return view('admin.features.edit', $this->formData($feature->load(['related', 'screenshots'])));
    }

    public function update(FeatureRequest $request, Feature $feature): RedirectResponse
    {
        $data = $this->payload($request);

        foreach (['spot', 'scene'] as $image) {
            if ($request->hasFile($image) || $request->boolean("remove_{$image}")) {
                if ($feature->{"{$image}_path"}) {
                    Storage::disk('public')->delete($feature->{"{$image}_path"});
                }
                $data["{$image}_path"] = $request->hasFile($image) ? $request->file($image)->store('features', 'public') : null;
            }
        }

        $feature->update($data);
        $this->syncRelated($feature, $request);
        $this->syncScreenshots($feature, $request);

        return redirect()->route('admin.features.index')->with('status', 'Feature updated.');
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        Storage::disk('public')->delete($feature->load('screenshots')->storedFiles());

        $feature->delete();

        return redirect()->route('admin.features.index')->with('status', 'Feature deleted.');
    }

    /**
     * Validated columns of the features table.
     *
     * @return array<string, mixed>
     */
    private function payload(FeatureRequest $request): array
    {
        return collect($request->validated())->except([
            'related', 'spot', 'remove_spot', 'scene', 'remove_scene',
            'screenshots', 'new_screenshot_captions', 'new_screenshot_captions_si', 'screenshot_captions',
            'screenshot_captions_si', 'screenshot_order', 'remove_screenshots',
        ])->all();
    }

    /**
     * Keeps the related modules in the order they are listed on the form.
     */
    private function syncRelated(Feature $feature, FeatureRequest $request): void
    {
        $feature->related()->sync(
            collect($request->validated('related', []))
                ->map(fn ($id) => (int) $id)
                ->reject(fn (int $id) => $id === $feature->id)
                ->unique()
                ->values()
                ->mapWithKeys(fn (int $id, int $i) => [$id => ['sort_order' => $i]])
        );
    }

    /**
     * Removes ticked screenshots, saves captions (English and Sinhala) and order of the rest,
     * then appends new uploads with their captions.
     */
    private function syncScreenshots(Feature $feature, FeatureRequest $request): void
    {
        $remove = collect($request->validated('remove_screenshots', []))->map(fn ($id) => (int) $id);
        $captions = $request->validated('screenshot_captions', []);
        $captionsSi = $request->validated('screenshot_captions_si', []);
        $order = $request->validated('screenshot_order', []);

        foreach ($feature->screenshots()->get() as $screenshot) {
            if ($remove->contains($screenshot->id)) {
                Storage::disk('public')->delete($screenshot->path);
                $screenshot->delete();

                continue;
            }

            $screenshot->update([
                'caption' => $captions[$screenshot->id] ?? $screenshot->caption,
                'caption_si' => $captionsSi[$screenshot->id] ?? $screenshot->caption_si,
                'sort_order' => (int) ($order[$screenshot->id] ?? $screenshot->sort_order),
            ]);
        }

        $next = (int) $feature->screenshots()->max('sort_order') + 1;
        $newCaptions = $request->validated('new_screenshot_captions', []);
        $newCaptionsSi = $request->validated('new_screenshot_captions_si', []);

        foreach ($request->file('screenshots', []) as $i => $file) {
            $feature->screenshots()->create([
                'path' => $file->store('features/screenshots', 'public'),
                'caption' => $newCaptions[$i] ?? null,
                'caption_si' => $newCaptionsSi[$i] ?? null,
                'sort_order' => $next + $i,
            ]);
        }
    }

    /**
     * @return array{feature: Feature, others: Collection<int, Feature>}
     */
    private function formData(Feature $feature): array
    {
        return [
            'feature' => $feature,
            'others' => Feature::ordered()->when($feature->exists, fn ($q) => $q->whereKeyNot($feature->id))->get(['id', 'title', 'icon', 'is_active']),
        ];
    }
}
