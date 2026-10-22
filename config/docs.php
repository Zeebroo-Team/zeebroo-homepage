<?php

/*
|--------------------------------------------------------------------------
| Documentation
|--------------------------------------------------------------------------
|
| The Zeebroo POS desktop user guide shown at /docs. Each page's body lives in
| resources/views/frontend/docs/chapters/{slug}.blade.php (Sinhala copy in
| {slug}_si.blade.php); `sections` lists the anchors (id => heading) inside that
| file for the "On this page" menu. Any `{key}_si` value replaces `{key}` when the
| website is in Sinhala. Pages are shown in this order, grouped by `group`.
|
*/

return [

    'version' => 'v3.1.0',

    'guide_pdf' => 'assets/docs/zeebroo-pos-user-guide.pdf',

    'groups' => [
        'start' => 'Getting started',
        'daily' => 'Selling & stock',
        'business' => 'Money & people',
        'restaurant' => 'Restaurant',
        'setup' => 'Set up',
        'release' => 'Release notes',
    ],

    'groups_si' => [
        'start' => 'ආරම්භ කිරීම',
        'daily' => 'විකිණීම සහ තොග',
        'business' => 'මුදල් සහ කාර්ය මණ්ඩලය',
        'restaurant' => 'අවන්හල',
        'setup' => 'සැකසීම',
        'release' => 'නව යාවත්කාලීන',
    ],

    // Shortcuts on the docs home page to the jobs people look up most (page slug + section anchor)
    'tasks' => [
        ['icon' => 'fa-cart-shopping', 'page' => 'point-of-sale', 'anchor' => 'starting-a-sale', 'title' => 'Make a sale', 'title_si' => 'විකිණීමක් කරන්න'],
        ['icon' => 'fa-box', 'page' => 'inventory-products', 'anchor' => 'adding-a-product', 'title' => 'Add a product', 'title_si' => 'නිෂ්පාදනයක් එක් කරන්න'],
        ['icon' => 'fa-rotate-left', 'page' => 'sales-returns', 'anchor' => 'processing-a-return', 'title' => 'Process a return', 'title_si' => 'ආපසු භාරදීමක් සකසන්න'],
        ['icon' => 'fa-moon', 'page' => 'sales-returns', 'anchor' => 'end-of-day-settlement', 'title' => 'Close the day', 'title_si' => 'දවස අවසන් කරන්න'],
        ['icon' => 'fa-truck', 'page' => 'inventory-products', 'anchor' => 'purchase-orders', 'title' => 'Order & receive stock', 'title_si' => 'තොග ඇණවුම් කර ලබාගන්න'],
        ['icon' => 'fa-money-check-dollar', 'page' => 'human-resources', 'anchor' => 'salary-payroll', 'title' => 'Run payroll', 'title_si' => 'වැටුප් ගෙවන්න'],
        ['icon' => 'fa-bell-concierge', 'page' => 'restaurant-pos', 'anchor' => 'taking-a-table-order', 'title' => 'Take a table order', 'title_si' => 'මේස ඇණවුමක් ගන්න'],
        ['icon' => 'fa-receipt', 'page' => 'settings-preferences', 'anchor' => 'receipt-customisation', 'title' => 'Customise your receipt', 'title_si' => 'රිසිට්පත සකස් කරන්න'],
    ],

    'pages' => [

        'getting-started' => [
            'group' => 'start',
            'number' => '01',
            'icon' => 'fa-rocket',
            'title' => 'Registration & Setup',
            'title_si' => 'ලියාපදිංචිය සහ සැකසීම',
            'description' => 'Create your account, set up your business profile, choose your industry, and select the features your business needs.',
            'description_si' => 'ඔබේ ගිණුම සාදා, ව්‍යාපාර තොරතුරු ඇතුළත් කර, ව්‍යාපාර ක්ෂේත්‍රය තෝරා, ඔබේ ව්‍යාපාරයට අවශ්‍ය විශේෂාංග සක්‍රිය කරගන්න.',
            'sections' => [
                'creating-your-account' => 'Creating Your Account',
                'available-features' => 'Available Features',
                'signing-in-to-an-existing-account' => 'Signing In to an Existing Account',
                'switching-businesses-or-branches' => 'Switching Businesses or Branches',
            ],
            'sections_si' => [
                'creating-your-account' => 'ඔබේ ගිණුම සෑදීම',
                'available-features' => 'ලබාගත හැකි විශේෂාංග',
                'signing-in-to-an-existing-account' => 'පවතින ගිණුමකට පිවිසීම',
                'switching-businesses-or-branches' => 'ව්‍යාපාර හෝ ශාඛා මාරු කිරීම',
            ],
        ],

        'home-dashboard' => [
            'group' => 'start',
            'number' => '02',
            'icon' => 'fa-house',
            'title' => 'Home Dashboard',
            'title_si' => 'මුල් පිටුවේ පාලක පුවරුව',
            'description' => 'Your command centre: daily KPIs, sales trends, quick actions, and a real-time activity feed.',
            'description_si' => 'ඔබේ ව්‍යාපාරයේ පාලන මධ්‍යස්ථානය: දිනපතා ප්‍රධාන දර්ශක, විකුණුම් ප්‍රවණතා, ඉක්මන් ක්‍රියා සහ තත්‍ය කාලීන ක්‍රියාකාරකම්.',
            'sections' => [
                'the-ribbon-interface' => 'The Ribbon Interface',
                'dashboard-kpis' => 'Dashboard KPIs',
                'sales-analytics-chart' => 'Sales Analytics Chart',
                'quick-actions' => 'Quick Actions',
                'real-time-activity-feed' => 'Real-time Activity Feed',
                'keyboard-shortcuts' => 'Keyboard Shortcuts',
            ],
            'sections_si' => [
                'the-ribbon-interface' => 'රිබන් අතුරුමුහුණත',
                'dashboard-kpis' => 'පාලක පුවරුවේ ප්‍රධාන දර්ශක',
                'sales-analytics-chart' => 'විකුණුම් විශ්ලේෂණ ප්‍රස්තාරය',
                'quick-actions' => 'ඉක්මන් ක්‍රියා',
                'real-time-activity-feed' => 'තත්‍ය කාලීන ක්‍රියාකාරකම්',
                'keyboard-shortcuts' => 'යතුරුපුවරු කෙටිමං',
            ],
        ],

        'point-of-sale' => [
            'group' => 'daily',
            'number' => '03',
            'icon' => 'fa-cash-register',
            'title' => 'Point of Sale',
            'title_si' => 'විකුණුම් ස්ථානය (POS)',
            'description' => 'Process sales quickly, manage your cart, handle multiple sessions, and check out customers with cash, card, or bank transfer.',
            'description_si' => 'විකුණුම් ඉක්මනින් සම්පූර්ණ කරන්න, කරත්තය කළමනාකරණය කරන්න, එකවර බිල්පත් කිහිපයක් හසුරුවන්න, සහ මුදල්, කාඩ්පත් හෝ බැංකු මාරු මගින් ගෙවීම් ලබාගන්න.',
            'sections' => [
                'the-pos-layout' => 'The POS Layout',
                'starting-a-sale' => 'Starting a Sale',
                'multiple-pos-sessions-tabs' => 'Multiple POS Sessions (Tabs)',
                'parking-an-order' => 'Parking an Order',
                'customers' => 'Customers',
                'quotations' => 'Quotations',
                'pos-keyboard-shortcuts' => 'POS Keyboard Shortcuts',
            ],
            'sections_si' => [
                'the-pos-layout' => 'POS තිරයේ සැකැස්ම',
                'starting-a-sale' => 'විකිණීමක් ආරම්භ කිරීම',
                'multiple-pos-sessions-tabs' => 'එකවර POS සැසි කිහිපයක් (ටැබ්)',
                'parking-an-order' => 'ඇණවුමක් තාවකාලිකව නවත්වා තැබීම',
                'customers' => 'පාරිභෝගිකයන්',
                'quotations' => 'මිල ගණන් පත්‍ර',
                'pos-keyboard-shortcuts' => 'POS යතුරුපුවරු කෙටිමං',
            ],
        ],

        'sales-returns' => [
            'group' => 'daily',
            'number' => '04',
            'icon' => 'fa-receipt',
            'title' => 'Sales & Returns',
            'title_si' => 'විකුණුම් සහ ආපසු භාරදීම්',
            'description' => 'View your transaction history, handle customer returns, run end-of-day settlement, and manage sales invoices.',
            'description_si' => 'ගනුදෙනු ඉතිහාසය බලන්න, පාරිභෝගිකයන්ගේ ආපසු භාරදීම් හසුරුවන්න, දවස අවසානයේ ගිණුම් සමථය කරන්න, සහ විකුණුම් ඉන්වොයිසි කළමනාකරණය කරන්න.',
            'sections' => [
                'transaction-history' => 'Transaction History',
                'sales-history-analytics' => 'Sales History & Analytics',
                'processing-a-return' => 'Processing a Return',
                'end-of-day-settlement' => 'End-of-Day Settlement',
                'sales-invoices' => 'Sales Invoices',
            ],
            'sections_si' => [
                'transaction-history' => 'ගනුදෙනු ඉතිහාසය',
                'sales-history-analytics' => 'විකුණුම් ඉතිහාසය සහ විශ්ලේෂණ',
                'processing-a-return' => 'ආපසු භාරදීමක් සැකසීම',
                'end-of-day-settlement' => 'දවස අවසානයේ ගිණුම් සමථය',
                'sales-invoices' => 'විකුණුම් ඉන්වොයිසි',
            ],
        ],

        'inventory-products' => [
            'group' => 'daily',
            'number' => '05',
            'icon' => 'fa-boxes-stacked',
            'title' => 'Inventory & Products',
            'title_si' => 'තොග සහ නිෂ්පාදන',
            'description' => 'Build your product catalog, track stock, manage suppliers and purchase orders, and print barcodes.',
            'description_si' => 'ඔබේ නිෂ්පාදන නාමාවලිය සාදන්න, තොග මට්ටම් නිරීක්ෂණය කරන්න, සැපයුම්කරුවන් සහ මිලදී ගැනීමේ ඇණවුම් කළමනාකරණය කරන්න, බාර්කෝඩ් මුද්‍රණය කරන්න.',
            'sections' => [
                'adding-a-product' => 'Adding a Product',
                'categories-brands' => 'Categories & Brands',
                'stock-management' => 'Stock Management',
                'suppliers' => 'Suppliers',
                'purchase-orders' => 'Purchase Orders',
                'barcode-printing' => 'Barcode Printing',
            ],
            'sections_si' => [
                'adding-a-product' => 'නිෂ්පාදනයක් එක් කිරීම',
                'categories-brands' => 'කාණ්ඩ සහ වෙළඳ නාම',
                'stock-management' => 'තොග කළමනාකරණය',
                'suppliers' => 'සැපයුම්කරුවන්',
                'purchase-orders' => 'මිලදී ගැනීමේ ඇණවුම්',
                'barcode-printing' => 'බාර්කෝඩ් මුද්‍රණය',
            ],
        ],

        'finance-accounts' => [
            'group' => 'business',
            'number' => '06',
            'icon' => 'fa-building-columns',
            'title' => 'Finance & Accounts',
            'title_si' => 'මූල්‍ය සහ ගිණුම්',
            'description' => 'Monitor cash flow, manage bills and expenses, track loans, handle rental income, and maintain your financial accounts.',
            'description_si' => 'මුදල් ප්‍රවාහය නිරීක්ෂණය කරන්න, බිල්පත් සහ වියදම් කළමනාකරණය කරන්න, ණය සහ කුලී ගනුදෙනු සටහන් කරන්න, සහ ඔබේ මූල්‍ය ගිණුම් පවත්වාගන්න.',
            'sections' => [
                'financial-overview-cash-flow' => 'Financial Overview: Cash Flow',
                'bank-accounts' => 'Bank Accounts',
                'bill-management' => 'Bill Management',
                'loans' => 'Loans',
                'rentals-properties' => 'Rentals & Properties',
                'finance-reports' => 'Finance Reports',
            ],
            'sections_si' => [
                'financial-overview-cash-flow' => 'මූල්‍ය දළ විශ්ලේෂණය: මුදල් ප්‍රවාහය',
                'bank-accounts' => 'බැංකු ගිණුම්',
                'bill-management' => 'බිල්පත් කළමනාකරණය',
                'loans' => 'ණය',
                'rentals-properties' => 'කුලී සහ දේපළ',
                'finance-reports' => 'මූල්‍ය වාර්තා',
            ],
        ],

        'human-resources' => [
            'group' => 'business',
            'number' => '07',
            'icon' => 'fa-users',
            'title' => 'Human Resources',
            'title_si' => 'මානව සම්පත්',
            'description' => 'Manage your team: employee records, departments, salary structures, payroll runs, and attendance tracking.',
            'description_si' => 'ඔබේ කාර්ය මණ්ඩලය කළමනාකරණය කරන්න: සේවක වාර්තා, දෙපාර්තමේන්තු, වැටුප් ව්‍යුහ, වැටුප් ගෙවීම් සහ පැමිණීම් වාර්තා.',
            'sections' => [
                'adding-employees' => 'Adding Employees',
                'departments' => 'Departments',
                'salary-payroll' => 'Salary & Payroll',
                'attendance' => 'Attendance',
            ],
            'sections_si' => [
                'adding-employees' => 'සේවකයන් එක් කිරීම',
                'departments' => 'දෙපාර්තමේන්තු',
                'salary-payroll' => 'වැටුප් සහ වැටුප් ලේඛනය',
                'attendance' => 'පැමිණීම',
            ],
        ],

        'design-studio' => [
            'group' => 'business',
            'number' => '08',
            'icon' => 'fa-palette',
            'title' => 'Design Studio',
            'title_si' => 'ඩිසයින් ස්ටූඩියෝ',
            'description' => 'Create branded social media content, marketing banners, and promotional graphics directly inside the app.',
            'description_si' => 'ඔබේ සන්නාමයට ගැළපෙන සමාජ මාධ්‍ය පළකිරීම්, ප්‍රචාරණ බැනර් සහ ප්‍රවර්ධන නිර්මාණ ඇප් එක තුළින්ම සාදන්න.',
            'sections' => [
                'creating-a-campaign' => 'Creating a Campaign',
                'design-types' => 'Design Types',
                'how-to-create-a-letterhead' => 'How to Create a Letterhead',
            ],
            'sections_si' => [
                'creating-a-campaign' => 'ප්‍රචාරණ නිර්මාණයක් සෑදීම',
                'design-types' => 'නිර්මාණ වර්ග',
                'how-to-create-a-letterhead' => 'ලිපි ශීර්ෂයක් සාදන ආකාරය',
            ],
        ],

        'restaurant-management' => [
            'group' => 'restaurant',
            'number' => '09',
            'icon' => 'fa-utensils',
            'title' => 'Restaurant Management',
            'title_si' => 'අවන්හල් කළමනාකරණය',
            'description' => 'Set up tables and floor plans, build your menu, manage dine-in orders, run the Kitchen Display System, and control ingredients.',
            'description_si' => 'මේස සහ ආසන සැලැස්ම සකසන්න, මෙනුව සාදන්න, ඇණවුම් කළමනාකරණය කරන්න, මුළුතැන්ගෙයි තිරය (KDS) භාවිත කරන්න, සහ අමුද්‍රව්‍ය පාලනය කරන්න.',
            'sections' => [
                'setting-up-tables' => 'Setting Up Tables',
                'building-your-menu' => 'Building Your Menu',
                'managing-orders' => 'Managing Orders',
                'kitchen-display-system-kds' => 'Kitchen Display System (KDS)',
                'ingredient-management' => 'Ingredient Management',
                'ingredient-purchase-orders' => 'Ingredient Purchase Orders',
            ],
            'sections_si' => [
                'setting-up-tables' => 'මේස සැකසීම',
                'building-your-menu' => 'ඔබේ මෙනුව සෑදීම',
                'managing-orders' => 'ඇණවුම් කළමනාකරණය',
                'kitchen-display-system-kds' => 'මුළුතැන්ගෙයි තිරය (KDS)',
                'ingredient-management' => 'අමුද්‍රව්‍ය කළමනාකරණය',
                'ingredient-purchase-orders' => 'අමුද්‍රව්‍ය මිලදී ගැනීමේ ඇණවුම්',
            ],
        ],

        'restaurant-pos' => [
            'group' => 'restaurant',
            'number' => '10',
            'icon' => 'fa-bell-concierge',
            'title' => 'Restaurant POS',
            'title_si' => 'අවන්හල් POS',
            'description' => 'Take dine-in table orders and takeaway orders, track kitchen status in real time, and process payment when all dishes are served.',
            'description_si' => 'මේස ඇණවුම් සහ රැගෙන යන (takeaway) ඇණවුම් ගන්න, මුළුතැන්ගෙයි තත්ත්වය තත්‍ය කාලීනව බලන්න, සියලු කෑම පිළිගැන්වූ පසු ගෙවීම ලබාගන්න.',
            'sections' => [
                'the-restaurant-pos-interface' => 'The Restaurant POS Interface',
                'taking-a-table-order' => 'Taking a Table Order',
                'taking-a-takeaway-order' => 'Taking a Takeaway Order',
                'multiple-active-orders' => 'Multiple Active Orders',
            ],
            'sections_si' => [
                'the-restaurant-pos-interface' => 'අවන්හල් POS තිරය',
                'taking-a-table-order' => 'මේස ඇණවුමක් ගැනීම',
                'taking-a-takeaway-order' => 'රැගෙන යන ඇණවුමක් ගැනීම',
                'multiple-active-orders' => 'එකවර ඇණවුම් කිහිපයක්',
            ],
        ],

        'feature-management' => [
            'group' => 'setup',
            'number' => '11',
            'icon' => 'fa-toggle-on',
            'title' => 'Feature Management',
            'title_si' => 'විශේෂාංග කළමනාකරණය',
            'description' => 'Enable or disable features at any time. Changes take effect immediately after the app reloads.',
            'description_si' => 'ඕනෑම වේලාවක විශේෂාංග සක්‍රිය හෝ අක්‍රිය කරන්න. ඇප් එක නැවත පූරණය වූ විගසම වෙනස්කම් ක්‍රියාත්මක වේ.',
            'sections' => [
                'opening-feature-management' => 'Opening Feature Management',
                'enabling-and-disabling-features' => 'Enabling and Disabling Features',
                'industry-specific-defaults' => 'Industry-Specific Defaults',
            ],
            'sections_si' => [
                'opening-feature-management' => 'විශේෂාංග කළමනාකරණය විවෘත කිරීම',
                'enabling-and-disabling-features' => 'විශේෂාංග සක්‍රිය සහ අක්‍රිය කිරීම',
                'industry-specific-defaults' => 'ව්‍යාපාර ක්ෂේත්‍රය අනුව පෙරනිමි',
            ],
        ],

        'settings-preferences' => [
            'group' => 'setup',
            'number' => '12',
            'icon' => 'fa-gear',
            'title' => 'Settings & Preferences',
            'title_si' => 'සැකසුම් සහ මනාපයන්',
            'description' => "Customise the app's behaviour, configure your receipt, adjust the display theme, and manage your subscription.",
            'description_si' => 'ඇප් එක ක්‍රියා කරන ආකාරය, රිසිට්පත, තිරයේ පෙනුම සහ ඔබේ දායකත්වය ඔබට ගැළපෙන ලෙස සකසාගන්න.',
            'sections' => [
                'opening-pos-settings' => 'Opening POS Settings',
                'general-settings' => 'General Settings',
                'accounts-settings' => 'Accounts Settings',
                'receipt-customisation' => 'Receipt Customisation',
                'toggling-dark-mode' => 'Toggling Dark Mode',
                'checking-for-updates' => 'Checking for Updates',
                'signing-out' => 'Signing Out',
            ],
            'sections_si' => [
                'opening-pos-settings' => 'POS සැකසුම් විවෘත කිරීම',
                'general-settings' => 'සාමාන්‍ය සැකසුම්',
                'accounts-settings' => 'ගිණුම් සැකසුම්',
                'receipt-customisation' => 'රිසිට්පත සැකසීම',
                'toggling-dark-mode' => 'අඳුරු මාදිලිය',
                'checking-for-updates' => 'යාවත්කාලීන පරීක්ෂා කිරීම',
                'signing-out' => 'ඉවත් වීම',
            ],
        ],

        'whats-new' => [
            'group' => 'release',
            'number' => 'v3.1',
            'icon' => 'fa-wand-magic-sparkles',
            'title' => "What's new in v3.1.0",
            'title_si' => 'v3.1.0 හි අලුතින් ඇති දේ',
            'description' => 'Four new views on your Home dashboard: hourly sales charts, an expense tracker, a profit calculator, and a payroll summary.',
            'description_si' => 'මුල් පිටුවේ පාලක පුවරුවට නව දසුන් හතරක්: පැයෙන් පැයට විකුණුම් ප්‍රස්තාර, වියදම් දළ විශ්ලේෂණය, ලාභ වාර්තාව සහ වැටුප් සාරාංශය.',
            'sections' => [
                'overview' => 'Overview',
                'ch-today' => 'Today Tab: Hourly Charts',
                'ch-expenses' => 'Expenses Overview',
                'ch-profit' => 'Profit Report',
                'ch-payroll' => 'Payroll Dashboard',
                'ch-ribbon' => 'Ribbon Shortcuts',
            ],
            'sections_si' => [
                'overview' => 'දළ විශ්ලේෂණය',
                'ch-today' => 'Today ටැබය: පැයෙන් පැයට ප්‍රස්තාර',
                'ch-expenses' => 'වියදම් දළ විශ්ලේෂණය',
                'ch-profit' => 'ලාභ වාර්තාව',
                'ch-payroll' => 'වැටුප් පාලක පුවරුව',
                'ch-ribbon' => 'රිබන් කෙටිමං',
            ],
        ],

    ],

];
