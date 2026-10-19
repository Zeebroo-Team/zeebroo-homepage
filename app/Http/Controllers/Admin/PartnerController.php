<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use App\Models\PartnerCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view partners', only: ['index']),
            new Middleware('permission:create partners', only: ['create', 'store']),
            new Middleware('permission:edit partners', only: ['edit', 'update']),
            new Middleware('permission:delete partners', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $categoryId = $request->integer('category') ?: null;

        $partners = Partner::with('category')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($categoryId, fn ($q) => $q->where('partner_category_id', $categoryId))
            ->ordered()
            ->paginate(25)
            ->withQueryString();

        return view('admin.partners.index', [
            'partners' => $partners,
            'search' => $search,
            'categoryId' => $categoryId,
            'categories' => PartnerCategory::ordered()->pluck('name', 'id'),
        ]);
    }

    public function create(): View
    {
        return view('admin.partners.create', $this->formData(new Partner([
            'is_active' => true,
            'sort_order' => (int) Partner::max('sort_order') + 1,
        ])));
    }

    public function store(PartnerRequest $request): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('status', 'Partner created.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', $this->formData($partner));
    }

    public function update(PartnerRequest $request, Partner $partner): RedirectResponse
    {
        $data = $this->payload($request);

        if ($request->hasFile('logo') || $request->boolean('remove_logo')) {
            if ($partner->logo_path) {
                Storage::disk('public')->delete($partner->logo_path);
            }
            $data['logo_path'] = $request->hasFile('logo') ? $request->file('logo')->store('partners', 'public') : null;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('status', 'Partner updated.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('status', 'Partner deleted.');
    }

    /**
     * Validated columns of the partners table.
     *
     * @return array<string, mixed>
     */
    private function payload(PartnerRequest $request): array
    {
        return collect($request->validated())->except(['logo', 'remove_logo'])->all();
    }

    /**
     * @return array{partner: Partner, categories: Collection<int, string>}
     */
    private function formData(Partner $partner): array
    {
        return [
            'partner' => $partner,
            'categories' => PartnerCategory::ordered()->pluck('name', 'id'),
        ];
    }
}
