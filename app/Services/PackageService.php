<?php

namespace App\Services;

use App\Models\Feature;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Subscription packages, as set up in the platform's admin panel
 * (Admin → Package Management), read from the platform's public API.
 */
class PackageService
{
    // Platform feature keys whose homepage page slug isn't just the key with dashes
    private const FEATURE_SLUGS = [
        'service_management' => 'services',
    ];

    /** @return array<string, array> slug => package, in the platform's sort order */
    public function all(): array
    {
        $cached = Cache::get('packages.all');
        if ($cached !== null) {
            return $cached;
        }

        $packages = $this->fetch();
        // A failed lookup is cached briefly so a platform outage doesn't slow every page view
        Cache::put('packages.all', $packages ?? [], $packages ? now()->addMinutes(10) : now()->addMinute());

        return $packages ?? [];
    }

    public function find(string $slug): ?array
    {
        return $this->all()[$slug] ?? null;
    }

    /** Every feature offered by any package, keyed by platform key, in first-seen order */
    public function allFeatures(): array
    {
        $features = [];
        foreach ($this->all() as $package) {
            foreach ($package['features'] as $key => $feature) {
                $features[$key] ??= $feature;
            }
        }

        return $features;
    }

    private function fetch(): ?array
    {
        $base = rtrim((string) config('services.zeebroo.platform_url'), '/');

        try {
            $data = Http::acceptJson()->timeout(4)
                ->get($base.'/api/v1/pos/auth/packages')
                ->throw()
                ->json('data');
        } catch (\Throwable $e) {
            Log::warning('Package lookup failed: '.$e->getMessage());

            return null;
        }

        if (! is_array($data)) {
            return null;
        }

        // feature pages a package's modules link to, keyed by slug
        $pages = Feature::active()->get(['slug', 'title', 'icon', 'menu'])->keyBy('slug')->all();

        $packages = [];
        foreach ($data as $row) {
            if (! is_array($row) || empty($row['slug']) || empty($row['name'])) {
                continue;
            }
            $packages[(string) $row['slug']] = $this->normalize($row, $pages);
        }

        return $packages;
    }

    /** @param array<string, Feature> $pages */
    private function normalize(array $row, array $pages): array
    {
        $price = (float) ($row['price'] ?? 0);
        $discounted = isset($row['discounted_price']) ? (float) $row['discounted_price'] : null;
        $hasDiscount = $discounted !== null && $discounted < $price;
        $isFree = (bool) ($row['is_free'] ?? false);

        $features = [];
        foreach (array_values($row['features'] ?? []) as $i => $key) {
            $slug = self::FEATURE_SLUGS[$key] ?? str_replace('_', '-', (string) $key);
            $page = $pages[$slug] ?? null;
            $features[$key] = [
                'label' => $row['feature_labels'][$i] ?? ($page['title'] ?? ucwords(str_replace('_', ' ', (string) $key))),
                'slug' => $page ? $slug : null,
                'icon' => $page['icon'] ?? 'fa-puzzle-piece',
                'menu' => $page['menu'] ?? null,
            ];
        }

        $symbol = (string) ($row['currency_symbol'] ?? (($row['currency'] ?? '').' '));
        $money = fn (float $v) => $symbol.number_format($v, fmod($v, 1) ? 2 : 0);

        return [
            'slug' => (string) $row['slug'],
            'name' => (string) $row['name'],
            'description' => $row['description'] ?? null,
            'image_url' => $row['image_url'] ?? null,
            'is_free' => $isFree,
            'price' => $isFree ? 'Free' : $money($hasDiscount ? $discounted : $price),
            'was' => ! $isFree && $hasDiscount ? $money($price) : null,
            'save' => ! $isFree && $hasDiscount && $price > 0 ? (int) round(100 - $discounted / $price * 100) : null,
            'pos_lite' => (bool) ($row['supports_pos_lite'] ?? false),
            'features' => $features,
        ];
    }
}
