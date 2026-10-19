<?php

namespace Database\Seeders;

use App\Models\PartnerCategory;
use Illuminate\Database\Seeder;

/**
 * Creates the starter partner categories. Runs only while the table is empty,
 * so it never overwrites changes made in the admin panel. Partners themselves are added in /admin.
 */
class PartnerCategorySeeder extends Seeder
{
    /**
     * @var list<array{name: string, icon: string, description: string}>
     */
    private const CATEGORIES = [
        ['name' => 'Technology partners', 'icon' => 'fa-microchip', 'description' => 'Hardware, cloud and software companies whose products work hand in hand with Zeebroo.'],
        ['name' => 'Payment partners', 'icon' => 'fa-credit-card', 'description' => 'Banks and payment providers that let you take card, QR and online payments at the till.'],
        ['name' => 'Reseller partners', 'icon' => 'fa-handshake', 'description' => 'Local experts who sell, install and support Zeebroo for businesses near them.'],
        ['name' => 'Clients', 'icon' => 'fa-store', 'description' => 'Businesses that run their sales, stock and people on Zeebroo every day.'],
    ];

    public function run(): void
    {
        if (PartnerCategory::query()->exists()) {
            return;
        }

        foreach (self::CATEGORIES as $position => $category) {
            PartnerCategory::create([...$category, 'sort_order' => $position]);
        }
    }
}
