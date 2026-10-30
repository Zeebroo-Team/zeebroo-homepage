<?php

/*
|--------------------------------------------------------------------------
| Social share previews
|--------------------------------------------------------------------------
|
| Open Graph and Twitter card text for feature pages, keyed by feature slug, for
| when a share preview should read differently from the page's meta title and
| description (set in /admin/features). `image` is a path under public/ and is
| only used once the file exists; until then the feature's own illustration is shared.
| A `{key}_si` value is used when the page is shown in Sinhala; without one the
| Sinhala page falls back to its Sinhala meta title and description.
|
| `default` is the site-wide title, description and share image, used by pages
| without their own (frontend.components.social-meta and the layout's <title>).
|
*/

return [

    'default' => [
        'title' => 'Zeebroo: the POS that runs your whole business',
        'description' => 'Zeebroo brings sales, stock, money, people and marketing into one workspace. Web and desktop POS, inventory, bills, HR and campaigns. All modules included.',
        'image' => 'assets/apple-touch-icon.png',
        'image_width' => 180,
        'image_height' => 180,
        'image_alt' => 'Zeebroo logo',
    ],

    'features' => [
        'point-of-sale' => [
            'title' => 'POS System Sri Lanka | Zeebroo',
            'description' => 'Manage billing, stock, accounts and reports with Zeebroo POS.',
            'twitter_description' => 'Web and desktop POS software for Sri Lankan businesses.',
            'image' => 'images/zeebroo-pos-social.jpg',
        ],
    ],

];
