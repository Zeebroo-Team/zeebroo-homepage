<?php

namespace App\Http\Controllers\Admin\Docs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Docs\DocGroupRequest;
use App\Models\DocGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class DocGroupController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view docs', only: ['index']),
            new Middleware('permission:create docs', only: ['create', 'store']),
            new Middleware('permission:edit docs', only: ['edit', 'update']),
            new Middleware('permission:delete docs', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        return view('admin.docs.groups.index', [
            'groups' => DocGroup::ordered()->withCount('pages')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.docs.groups.create', ['group' => new DocGroup([
            'sort_order' => (int) DocGroup::max('sort_order') + 1,
        ])]);
    }

    public function store(DocGroupRequest $request): RedirectResponse
    {
        DocGroup::create($request->validated());

        return redirect()->route('admin.docs.groups.index')->with('status', 'Docs group created.');
    }

    public function edit(DocGroup $group): View
    {
        return view('admin.docs.groups.edit', ['group' => $group]);
    }

    public function update(DocGroupRequest $request, DocGroup $group): RedirectResponse
    {
        $group->update($request->validated());

        return redirect()->route('admin.docs.groups.index')->with('status', 'Docs group updated.');
    }

    public function destroy(DocGroup $group): RedirectResponse
    {
        if ($group->pages()->exists()) {
            return back()->withErrors(['delete' => "\"{$group->name}\" still has pages. Move them to another group first."]);
        }

        $group->delete();

        return redirect()->route('admin.docs.groups.index')->with('status', 'Docs group deleted.');
    }
}
