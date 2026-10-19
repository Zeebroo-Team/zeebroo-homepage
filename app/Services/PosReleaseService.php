<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Latest desktop POS release, as published in the platform's admin panel
 * (Admin → Releases), read from the platform's public API.
 */
class PosReleaseService
{
    // Order is also the fallback order when the visitor's own OS has no build
    public const PLATFORMS = [
        'windows'     => ['label' => 'Windows',            'icon' => 'fa-brands fa-windows', 'field' => 'windows_url'],
        'macos'       => ['label' => 'macOS (Apple chip)', 'icon' => 'fa-brands fa-apple',   'field' => 'macos_url'],
        'macos_intel' => ['label' => 'macOS (Intel)',      'icon' => 'fa-brands fa-apple',   'field' => 'macos_intel_url'],
        'linux'       => ['label' => 'Linux',              'icon' => 'fa-brands fa-linux',   'field' => 'linux_url'],
    ];

    /** @return array{version: ?string, downloads: array<string, string>}|null */
    public function latest(): ?array
    {
        $cached = Cache::get('pos_release.latest');
        if ($cached !== null) {
            return $cached ?: null;
        }

        $release = $this->fetch();
        // A failed lookup is cached briefly so a platform outage doesn't slow every page view
        Cache::put('pos_release.latest', $release ?? [], $release ? now()->addMinutes(10) : now()->addMinute());

        return $release;
    }

    /** Platform key => download URL, only for builds that exist */
    public function downloads(): array
    {
        return $this->latest()['downloads'] ?? [];
    }

    /** Best build for a user agent: the visitor's OS first (a Mac falls back to the Intel build), else null */
    public function pickFor(string $userAgent): ?string
    {
        $downloads = $this->downloads();

        foreach ($this->preferredFor($userAgent) as $key) {
            if (isset($downloads[$key])) {
                return $key;
            }
        }

        return null;
    }

    /** @return list<string> */
    private function preferredFor(string $ua): array
    {
        return match (true) {
            // Phones and tablets have no desktop build — check these before Linux/Mac, which their UAs contain
            (bool) preg_match('/Android|iPhone|iPad|iPod|Mobile/i', $ua) => [],
            str_contains($ua, 'Windows')                                 => ['windows'],
            // Every Mac browser reports "Intel Mac OS X", so default to the Apple chip build
            (bool) preg_match('/Macintosh|Mac OS X/', $ua)               => ['macos', 'macos_intel'],
            (bool) preg_match('/Linux|X11|CrOS/', $ua)                   => ['linux'],
            default                                                      => [],
        };
    }

    private function fetch(): ?array
    {
        $base = rtrim((string) config('services.zeebroo.platform_url'), '/');

        try {
            $data = Http::acceptJson()->timeout(4)
                ->get($base . '/api/releases/latest', ['app' => 'main'])
                ->throw()
                ->json('data');
        } catch (\Throwable $e) {
            Log::warning('POS release lookup failed: ' . $e->getMessage());

            return null;
        }

        if (!is_array($data)) {
            return null;
        }

        $downloads = [];
        foreach (self::PLATFORMS as $key => $platform) {
            $url = $data[$platform['field']] ?? null;
            if (is_string($url) && filter_var($url, FILTER_VALIDATE_URL) && str_starts_with($url, 'https://')) {
                $downloads[$key] = $url;
            }
        }

        return [
            'version'   => isset($data['version']) ? ltrim((string) $data['version'], 'v') : null,
            'downloads' => $downloads,
        ];
    }
}
