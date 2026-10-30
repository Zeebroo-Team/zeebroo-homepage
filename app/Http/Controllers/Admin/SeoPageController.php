<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoPageRequest;
use App\Models\SeoPage;
use App\Services\SocialImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SeoPageController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view seo', only: ['index']),
            new Middleware('permission:edit seo', only: ['edit', 'update']),
        ];
    }

    public function index(): View
    {
        $saved = SeoPage::whereIn('key', array_keys(SeoPage::PAGES))->get()->keyBy('key');

        return view('admin.seo.pages.index', [
            'pages' => collect(SeoPage::PAGES)->keys()->map(fn (string $key): SeoPage => $saved[$key] ?? new SeoPage(['key' => $key])),
        ]);
    }

    public function edit(string $page): View
    {
        return view('admin.seo.pages.edit', ['page' => $this->findOrNew($page)]);
    }

    public function update(SeoPageRequest $request, SocialImageService $images, string $page): RedirectResponse
    {
        $seoPage = $this->findOrNew($page);
        $data = collect($request->validated())->except(['image', 'remove_image'])->all();

        if ($request->hasFile('image') || $request->boolean('remove_image')) {
            if ($seoPage->og_image_path) {
                Storage::disk('public')->delete($seoPage->og_image_path);
            }
            $data['og_image_path'] = $request->hasFile('image') ? $images->store($request->file('image')) : null;
        }

        $seoPage->fill($data)->save();

        return redirect()->route('admin.seo.pages.index')->with('status', "SEO for the {$seoPage->name} updated.");
    }

    /**
     * The saved settings for an editable page, or a blank record for it.
     */
    private function findOrNew(string $key): SeoPage
    {
        abort_unless(isset(SeoPage::PAGES[$key]), 404);

        return SeoPage::firstOrNew(['key' => $key]);
    }
}
