<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Enquiry;
use App\Models\Feature;
use App\Models\Industry;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Numbers, charts and to-dos for the admin dashboard. Each section is only
 * built when the signed-in user may view that part of the admin.
 */
class DashboardService
{
    /** Days shown in the enquiry chart and used for the "vs previous period" trend. */
    public const ENQUIRY_DAYS = 30;

    /** Months shown in the publishing chart. */
    public const POST_MONTHS = 6;

    /** A new enquiry with no reply after this many hours is flagged as overdue. */
    public const STALE_HOURS = 48;

    /**
     * @return array{
     *     enquiries: array<string, mixed>|null,
     *     blog: array<string, mixed>|null,
     *     website: list<array{label: string, icon: string, url: string, active: int, total: int}>,
     *     attention: list<array{icon: string, text: string, url: string, tone: string}>
     * }
     */
    public function for(User $user): array
    {
        $enquiries = $user->can('view enquiries') ? $this->enquiries() : null;
        $blog = $user->can('view blogs') ? $this->blog() : null;

        return [
            'enquiries' => $enquiries,
            'blog' => $blog,
            'website' => $this->website($user),
            'attention' => $this->attention($enquiries, $blog),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function enquiries(): array
    {
        $days = self::ENQUIRY_DAYS;
        $start = today()->subDays($days - 1);
        $previousStart = $start->copy()->subDays($days);

        $recentDates = Enquiry::where('created_at', '>=', $previousStart)->pluck('created_at');
        $current = $recentDates->filter(fn (Carbon $date): bool => $date->gte($start));
        $previous = $recentDates->count() - $current->count();

        $perDay = $current->countBy(fn (Carbon $date): string => $date->toDateString());
        $daily = collect(range(0, $days - 1))->map(function (int $offset) use ($start, $perDay): array {
            $day = $start->copy()->addDays($offset);

            return ['label' => $day->format('M j'), 'value' => $perDay->get($day->toDateString(), 0)];
        });

        $statusCounts = Enquiry::toBase()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $topicCounts = Enquiry::toBase()->selectRaw('topic, count(*) as total')->groupBy('topic')->pluck('total', 'topic');

        $busiest = $daily->sortByDesc('value')->first();
        $countable = (int) $statusCounts->sum() - (int) $statusCounts->get('spam', 0);
        $handled = (int) $statusCounts->get('in_progress', 0) + (int) $statusCounts->get('resolved', 0);

        return [
            'today' => (int) $perDay->get(today()->toDateString(), 0),
            'week' => $current->filter(fn (Carbon $date): bool => $date->gte(today()->subDays(6)))->count(),
            'average' => round($current->count() / $days, 1),
            'busiest' => $busiest['value'] ? $busiest : null,
            'handled_rate' => $countable > 0 ? (int) round($handled / $countable * 100) : null,
            'total' => (int) $statusCounts->sum(),
            'new' => (int) $statusCounts->get(Enquiry::STATUS_NEW, 0),
            'open' => (int) $statusCounts->get(Enquiry::STATUS_NEW, 0) + (int) $statusCounts->get('in_progress', 0),
            'stale' => Enquiry::unread()->where('created_at', '<', now()->subHours(self::STALE_HOURS))->count(),
            'period' => $current->count(),
            'trend' => $this->trend($current->count(), $previous),
            'daily' => $daily->all(),
            'statuses' => $this->breakdown(Enquiry::STATUSES, $statusCounts),
            'topics' => collect($this->breakdown(Enquiry::TOPICS, $topicCounts))->sortByDesc('value')->values()->all(),
            'recent' => Enquiry::latest()->latest('id')->take(5)->get(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function blog(): array
    {
        $months = self::POST_MONTHS;
        $start = now()->startOfMonth()->subMonths($months - 1);

        $perMonth = Blog::published()->where('published_at', '>=', $start)->pluck('published_at')
            ->countBy(fn (Carbon $date): string => $date->format('Y-m'));
        $monthly = collect(range(0, $months - 1))->map(function (int $offset) use ($start, $perMonth): array {
            $month = $start->copy()->addMonths($offset);

            return ['label' => $month->format('M'), 'value' => $perMonth->get($month->format('Y-m'), 0)];
        });

        return [
            'total' => Blog::count(),
            'published' => Blog::published()->count(),
            'scheduled' => Blog::where('is_active', true)->where('published_at', '>', now())->count(),
            'drafts' => Blog::where(fn ($q) => $q->where('is_active', false)->orWhereNull('published_at'))->count(),
            'this_month' => (int) $perMonth->get(now()->format('Y-m'), 0),
            'missing_image' => Blog::whereNull('image_path')->count(),
            'missing_meta' => Blog::where(fn ($q) => $q->whereNull('meta_description')->orWhere('meta_description', ''))->count(),
            'categories' => BlogCategory::count(),
            'tags' => BlogTag::count(),
            'monthly' => $monthly->all(),
            'upcoming' => Blog::where('is_active', true)->where('published_at', '>', now())->oldest('published_at')->take(3)->get(),
            'latest' => Blog::with('category')->latest()->take(5)->get(),
        ];
    }

    /**
     * Live vs total counts for the website content the user may manage.
     *
     * @return list<array{label: string, icon: string, url: string, active: int, total: int}>
     */
    private function website(User $user): array
    {
        $sections = [
            ['view features', 'Features', 'fa-layer-group', 'admin.features.index', Feature::class],
            ['view industries', 'Industries', 'fa-briefcase', 'admin.industries.index', Industry::class],
            ['view testimonials', 'Testimonials', 'fa-comment-dots', 'admin.testimonials.index', Testimonial::class],
            ['view partners', 'Partners', 'fa-handshake', 'admin.partners.index', Partner::class],
        ];

        return collect($sections)
            ->filter(fn (array $section): bool => $user->can($section[0]))
            ->map(fn (array $section): array => [
                'label' => $section[1],
                'icon' => $section[2],
                'url' => route($section[3]),
                'active' => $section[4]::active()->count(),
                'total' => $section[4]::count(),
            ])
            ->values()
            ->all();
    }

    /**
     * Things worth doing next, most urgent first. Empty means all caught up.
     *
     * @param  array<string, mixed>|null  $enquiries
     * @param  array<string, mixed>|null  $blog
     * @return list<array{icon: string, text: string, url: string, tone: string}>
     */
    private function attention(?array $enquiries, ?array $blog): array
    {
        $items = [];

        if ($enquiries && $enquiries['stale']) {
            $items[] = [
                'icon' => 'fa-clock', 'tone' => 'err', 'url' => route('admin.enquiries.index', ['status' => Enquiry::STATUS_NEW]),
                'text' => trans_choice('{1} :count enquiry has waited over :hours hours for a reply|[2,*] :count enquiries have waited over :hours hours for a reply', $enquiries['stale'], ['hours' => self::STALE_HOURS]),
            ];
        }
        if ($enquiries && $enquiries['new'] > $enquiries['stale']) {
            $fresh = $enquiries['new'] - $enquiries['stale'];
            $items[] = [
                'icon' => 'fa-inbox', 'tone' => 'warn', 'url' => route('admin.enquiries.index', ['status' => Enquiry::STATUS_NEW]),
                'text' => trans_choice('{1} :count new enquiry to reply to|[2,*] :count new enquiries to reply to', $fresh),
            ];
        }
        if ($blog && $blog['drafts']) {
            $items[] = [
                'icon' => 'fa-pen-ruler', 'tone' => 'info', 'url' => route('admin.blog.posts.index'),
                'text' => trans_choice('{1} :count post is still a draft|[2,*] :count posts are still drafts', $blog['drafts']),
            ];
        }
        if ($blog && $blog['missing_image']) {
            $items[] = [
                'icon' => 'fa-image', 'tone' => 'info', 'url' => route('admin.blog.posts.index'),
                'text' => trans_choice('{1} :count post has no featured image|[2,*] :count posts have no featured image', $blog['missing_image']),
            ];
        }
        if ($blog && $blog['missing_meta']) {
            $items[] = [
                'icon' => 'fa-magnifying-glass', 'tone' => 'info', 'url' => route('admin.blog.posts.index'),
                'text' => trans_choice('{1} :count post has no meta description (SEO)|[2,*] :count posts have no meta description (SEO)', $blog['missing_meta']),
            ];
        }

        return $items;
    }

    /**
     * Percent change against the previous period, or null when there is nothing to compare with.
     */
    private function trend(int $current, int $previous): ?int
    {
        return $previous > 0 ? (int) round(($current - $previous) / $previous * 100) : null;
    }

    /**
     * Every known key with its count (zero when missing) and share of the largest one.
     *
     * @param  array<string, string>  $labels
     * @param  Collection<string, int|string>  $counts
     * @return list<array{key: string, label: string, value: int, share: int}>
     */
    private function breakdown(array $labels, Collection $counts): array
    {
        $max = max(1, (int) $counts->max());

        return collect($labels)->map(fn (string $label, string $key): array => [
            'key' => $key,
            'label' => $label,
            'value' => (int) $counts->get($key, 0),
            'share' => (int) round((int) $counts->get($key, 0) / $max * 100),
        ])->values()->all();
    }
}
