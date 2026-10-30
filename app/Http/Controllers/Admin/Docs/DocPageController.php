<?php

namespace App\Http\Controllers\Admin\Docs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Docs\DocPageRequest;
use App\Models\DocGroup;
use App\Models\DocPage;
use App\Services\DocHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DocPageController extends Controller implements HasMiddleware
{
    /**
     * HTML fields of a page that are cleaned before saving.
     */
    private const HTML_FIELDS = ['intro', 'intro_si', 'outro', 'outro_si'];

    public function __construct(private DocHtmlSanitizer $sanitizer) {}

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

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $pages = DocPage::ordered()
            ->with('group')
            ->withCount('sections')
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w->where('doc_pages.title', 'like', "%{$search}%")->orWhere('doc_pages.slug', 'like', "%{$search}%")))
            ->get();

        return view('admin.docs.pages.index', [
            'pages' => $pages,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.docs.pages.create', [
            'page' => new DocPage([
                'icon' => 'fa-book',
                'is_active' => true,
                'sort_order' => (int) DocPage::max('sort_order') + 1,
            ]),
            'groups' => DocGroup::ordered()->get(),
        ]);
    }

    public function store(DocPageRequest $request): RedirectResponse
    {
        $page = DB::transaction(function () use ($request): DocPage {
            $page = DocPage::create($this->payload($request));
            $this->syncSections($page, $request->validated('sections'));

            return $page;
        });

        return redirect()->route('admin.docs.pages.index')->with('status', "Docs page \"{$page->title}\" created.");
    }

    public function edit(DocPage $page): View
    {
        return view('admin.docs.pages.edit', [
            'page' => $page->load('sections'),
            'groups' => DocGroup::ordered()->get(),
        ]);
    }

    public function update(DocPageRequest $request, DocPage $page): RedirectResponse
    {
        DB::transaction(function () use ($request, $page): void {
            $page->update(collect($this->payload($request))->except('slug')->all());
            $this->syncSections($page, $request->validated('sections'));
        });

        return redirect()->route('admin.docs.pages.index')->with('status', "Docs page \"{$page->title}\" updated.");
    }

    public function destroy(DocPage $page): RedirectResponse
    {
        if ($page->tasks()->exists()) {
            return back()->withErrors(['delete' => "\"{$page->title}\" has common tasks linking to it. Delete or move those tasks first."]);
        }

        $page->delete();

        return redirect()->route('admin.docs.pages.index')->with('status', "Docs page \"{$page->title}\" deleted.");
    }

    /**
     * Validated page columns, with the HTML fields cleaned.
     *
     * @return array<string, mixed>
     */
    private function payload(DocPageRequest $request): array
    {
        $data = collect($request->validated())->except('sections')->all();

        foreach (self::HTML_FIELDS as $field) {
            $data[$field] = $this->sanitizer->clean($data[$field] ?? null);
        }

        return $data;
    }

    /**
     * Replaces the page's sections with the submitted ones, in the order given.
     *
     * @param  list<array<string, mixed>>  $sections
     */
    private function syncSections(DocPage $page, array $sections): void
    {
        $page->sections()->delete();

        foreach ($sections as $order => $section) {
            $page->sections()->create([
                'anchor' => $section['anchor'],
                'heading' => $section['heading'],
                'heading_si' => $section['heading_si'] ?? null,
                'body' => $this->sanitizer->clean($section['body'] ?? null),
                'body_si' => $this->sanitizer->clean($section['body_si'] ?? null),
                'is_custom' => $section['is_custom'],
                'sort_order' => $order,
            ]);
        }
    }
}
