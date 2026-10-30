<?php

namespace App\Http\Controllers\Admin\Docs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Docs\DocTaskRequest;
use App\Models\DocPage;
use App\Models\DocTask;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class DocTaskController extends Controller implements HasMiddleware
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
        return view('admin.docs.tasks.index', [
            'tasks' => DocTask::ordered()->with('page.sections')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.docs.tasks.create', [
            'task' => new DocTask(['icon' => 'fa-check', 'sort_order' => (int) DocTask::max('sort_order') + 1]),
            'pages' => $this->pages(),
        ]);
    }

    public function store(DocTaskRequest $request): RedirectResponse
    {
        DocTask::create($request->validated());

        return redirect()->route('admin.docs.tasks.index')->with('status', 'Common task created.');
    }

    public function edit(DocTask $task): View
    {
        return view('admin.docs.tasks.edit', [
            'task' => $task,
            'pages' => $this->pages(),
        ]);
    }

    public function update(DocTaskRequest $request, DocTask $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()->route('admin.docs.tasks.index')->with('status', 'Common task updated.');
    }

    public function destroy(DocTask $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('admin.docs.tasks.index')->with('status', 'Common task deleted.');
    }

    /**
     * Every page with its sections, for the page and section dropdowns.
     *
     * @return Collection<int, DocPage>
     */
    private function pages(): Collection
    {
        return DocPage::ordered()->with('sections')->get();
    }
}
