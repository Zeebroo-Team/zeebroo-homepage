<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerCategoryRequest;
use App\Models\PartnerCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class PartnerCategoryController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view partner categories', only: ['index']),
            new Middleware('permission:create partner categories', only: ['create', 'store']),
            new Middleware('permission:edit partner categories', only: ['edit', 'update']),
            new Middleware('permission:delete partner categories', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $categories = PartnerCategory::withCount('partners')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->ordered()
            ->paginate(25)
            ->withQueryString();

        return view('admin.partners.categories.index', compact('categories', 'search'));
    }

    public function create(): View
    {
        return view('admin.partners.categories.create', ['category' => new PartnerCategory([
            'icon' => 'fa-handshake',
            'is_active' => true,
            'sort_order' => (int) PartnerCategory::max('sort_order') + 1,
        ])]);
    }

    public function store(PartnerCategoryRequest $request): RedirectResponse
    {
        PartnerCategory::create($request->validated());

        return redirect()->route('admin.partner-categories.index')->with('status', 'Category created.');
    }

    public function edit(PartnerCategory $partnerCategory): View
    {
        return view('admin.partners.categories.edit', ['category' => $partnerCategory]);
    }

    public function update(PartnerCategoryRequest $request, PartnerCategory $partnerCategory): RedirectResponse
    {
        $partnerCategory->update($request->validated());

        return redirect()->route('admin.partner-categories.index')->with('status', 'Category updated.');
    }

    public function destroy(PartnerCategory $partnerCategory): RedirectResponse
    {
        $partnerCategory->delete();

        return redirect()->route('admin.partner-categories.index')->with('status', 'Category deleted. Its partners are now uncategorised.');
    }
}
