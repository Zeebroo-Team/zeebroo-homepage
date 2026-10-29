<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Retitles the existing /features/point-of-sale page around "POS system Sri Lanka".
 * A field is only changed while it still holds the starter text (or is empty),
 * so anything rewritten in /admin/features is left alone.
 */
return new class extends Migration
{
    /**
     * Column => [starter text, new text].
     *
     * @var array<string, array{0: ?string, 1: string}>
     */
    private const CHANGES = [
        'headline' => ['Checkout that keeps the queue moving', 'A POS system for Sri Lanka that keeps the queue moving'],
        'headline_si' => ['පෝලිම් නැතිව ඉක්මනින් බිල් කරන්න', 'ශ්‍රී ලංකාවේ ව්‍යාපාර සඳහා පෝලිම් නැති POS පද්ධතිය'],
        'meta_title' => [null, 'POS System Sri Lanka | Web & Desktop'],
        'meta_title_si' => [null, 'ශ්‍රී ලංකාව සඳහා POS පද්ධතිය'],
        'meta_description' => [
            'Zeebroo Point of Sale: fast checkout, receipts and payments on web and desktop, connected to stock and accounts.',
            'POS system for Sri Lankan retail shops, restaurants and growing businesses. Manage billing, inventory, accounts and reports with Zeebroo.',
        ],
        'meta_description_si' => [
            'Zeebroo POS: වෙබ් සහ ඩෙස්ක්ටොප් දෙකෙන්ම ඉක්මන් බිල් කිරීම, රිසිට්පත් සහ ගෙවීම් ක්‍රම. තොගය සහ ගිණුම් සමඟ ස්වයංක්‍රීයව සම්බන්ධයි.',
            'ශ්‍රී ලංකාවේ වෙළඳසැල්, අවන්හල් සහ ව්‍යාපාර සඳහා POS පද්ධතිය. විකිණීම්, බිල්පත්, තොග සහ ගිණුම් එකම තැනකින් කළමනාකරණය කරන්න.',
        ],
        'meta_keywords' => [null, 'POS system Sri Lanka, POS software Sri Lanka, point of sale Sri Lanka, billing system Sri Lanka'],
        'meta_keywords_si' => [null, 'POS පද්ධතිය, POS system Sri Lanka, බිල් කිරීමේ මෘදුකාංග, POS software Sri Lanka'],
    ];

    public function up(): void
    {
        foreach (self::CHANGES as $column => [$old, $new]) {
            $this->swap($column, $old, $new);
        }
    }

    public function down(): void
    {
        foreach (self::CHANGES as $column => [$old, $new]) {
            $this->swap($column, $new, $old);
        }
    }

    private function swap(string $column, ?string $from, ?string $to): void
    {
        DB::table('features')
            ->where('slug', 'point-of-sale')
            ->where(fn ($q) => $from === null
                ? $q->whereNull($column)->orWhere($column, '')
                : $q->where($column, $from))
            ->update([$column => $to, 'updated_at' => now()]);
    }
};
