<?php

/*
| Industry pages: one entry per industry, keyed by its URL slug (/industries/{slug}).
| The header mega menu, the home "industries" grid, the /industries index and each
| industry page all read from here, so adding an industry is one new entry.
| "modules" are feature slugs from config/features.php shown as "Modules for ...".
| "scene" is an optional wide image in public/assets/features.
*/

return [

    'restaurant' => [
        'title' => 'Restaurant',
        'menu' => 'Tables, orders and kitchen flow',
        'icon' => 'fa-utensils',
        'badge' => 'Popular',
        'headline' => 'From the table to the kitchen without a lost order',
        'lead' => 'Take orders at the table or the counter, send them straight to the kitchen and settle the bill in seconds. Every dish sold draws down ingredients and lands in your accounts.',
        'description' => 'Zeebroo for restaurants: table orders, kitchen tickets, fast billing and ingredient stock in one POS.',
        'scene' => 'scenes/restaurant.webp',
        'highlights' => [
            ['fa-chair', 'Tables at a glance', 'See which tables are free, seated or waiting on the bill and move orders between them.'],
            ['fa-fire-burner', 'Straight to the kitchen', 'Orders reach the kitchen the moment they are placed, with notes and modifiers intact.'],
            ['fa-receipt', 'Split and settle', 'Split the bill by guest or item and take cash, card or both.'],
        ],
        'capabilities' => [
            'Dine in, takeaway and delivery orders',
            'Table layout with live order status',
            'Kitchen tickets with notes and modifiers',
            'Menu items, combos and add-ons',
            'Ingredient stock drawn down by every dish sold',
            'Daily sales, top dishes and staff reports',
        ],
        'modules' => ['restaurant', 'point-of-sale', 'stock-management', 'human-resources'],
    ],

    'retail-stores' => [
        'title' => 'Retail Stores',
        'menu' => 'Counter sales, stock and daily reports',
        'icon' => 'fa-store',
        'badge' => 'Popular',
        'headline' => 'Run the counter, the shelves and the books together',
        'lead' => 'Ring up sales fast, keep every shelf stocked and close the day with numbers that already match. Zeebroo grows from one shop to many branches without changing how you work.',
        'description' => 'Zeebroo for retail stores: fast counter sales, barcode scanning, live stock and daily reports.',
        'scene' => null,
        'highlights' => [
            ['fa-barcode', 'Fast checkout', 'Scan, search or tap products and charge the customer without a queue building up.'],
            ['fa-boxes-stacked', 'Stock that keeps up', 'Every sale updates stock, so you reorder before a best seller runs out.'],
            ['fa-chart-line', 'Daily close in minutes', 'Cash, card and sales totals add up on their own at the end of the day.'],
        ],
        'capabilities' => [
            'Barcode scanning and product search',
            'Discounts, promotions and tax worked out at the till',
            'Low stock alerts and reorder levels',
            'Customer records and purchase history',
            'Sales per cashier, product and category',
            'Multiple branches with shared products',
        ],
        'modules' => ['point-of-sale', 'stock-management', 'product-management', 'multibranch'],
    ],

    'ecommerce' => [
        'title' => 'Ecommerce',
        'menu' => 'Orders, inventory and fulfilment',
        'icon' => 'fa-bag-shopping',
        'badge' => null,
        'headline' => 'One stock count for the shop and the store front',
        'lead' => 'Manage online orders, inventory and fulfilment from the same place as your physical sales, so nothing gets sold twice and every order is tracked to the door.',
        'description' => 'Zeebroo for ecommerce: online orders, shared inventory and fulfilment tracking in one platform.',
        'scene' => null,
        'highlights' => [
            ['fa-cart-shopping', 'Every order in one list', 'Online and in-store orders sit side by side with their payment and delivery status.'],
            ['fa-warehouse', 'Shared inventory', 'One stock count for every channel, so you never sell what you no longer have.'],
            ['fa-truck-fast', 'Fulfilment tracked', 'Pick, pack and dispatch with a clear status for each order.'],
        ],
        'capabilities' => [
            'Order list with payment and delivery status',
            'Inventory shared across online and in-store sales',
            'Product catalogue with variants and images',
            'Customer records and order history',
            'Email updates and campaigns to customers',
            'Sales and fulfilment reports',
        ],
        'modules' => ['sales-management', 'product-management', 'stock-management', 'mail'],
    ],

    'manufacturing' => [
        'title' => 'Manufacturing',
        'menu' => 'Production, materials and dispatch',
        'icon' => 'fa-industry',
        'badge' => null,
        'headline' => 'Materials in, finished goods out, all accounted for',
        'lead' => 'Plan production, track raw materials and finished goods, and dispatch orders with costs that flow straight into the books.',
        'description' => 'Zeebroo for manufacturing: production planning, raw material stock, dispatch and costing.',
        'scene' => null,
        'highlights' => [
            ['fa-cubes', 'Raw materials tracked', 'Know what materials you hold, where they are and what each production run used.'],
            ['fa-gears', 'Production runs', 'Turn materials into finished goods and see the real cost of each batch.'],
            ['fa-truck-ramp-box', 'Dispatch on time', 'Track orders from the production floor to the customer.'],
        ],
        'capabilities' => [
            'Raw material and finished goods stock',
            'Batch tracking for production runs',
            'Purchase orders and supplier records',
            'Dispatch and delivery tracking',
            'Production costs linked to accounting',
            'Staff, shifts and payroll in the same system',
        ],
        'modules' => ['erp', 'stock-management', 'accounting', 'human-resources'],
    ],

    'spare-parts' => [
        'title' => 'Spare Parts',
        'menu' => 'Parts catalogue and fast checkout',
        'icon' => 'fa-gears',
        'badge' => null,
        'headline' => 'Find the right part in seconds',
        'lead' => 'Keep thousands of parts organised by code, brand and fit, find them fast at the counter and know exactly how many are on the rack.',
        'description' => 'Zeebroo for spare parts shops: searchable parts catalogue, fast checkout and accurate stock.',
        'scene' => null,
        'highlights' => [
            ['fa-magnifying-glass', 'Search by anything', 'Look parts up by code, name, brand or barcode and add them to the sale in one tap.'],
            ['fa-layer-group', 'Organised catalogue', 'Group parts by category and brand so large catalogues stay easy to manage.'],
            ['fa-file-invoice', 'Credit customers', 'Keep accounts for workshops and trade customers and track what they owe.'],
        ],
        'capabilities' => [
            'Parts catalogue with codes, brands and categories',
            'Barcode scanning and quick search at the counter',
            'Stock per rack, branch or warehouse',
            'Trade customer accounts and credit sales',
            'Supplier purchases and reorder levels',
            'Fast and slow mover reports',
        ],
        'modules' => ['point-of-sale', 'product-management', 'stock-management', 'crm'],
    ],

    'wholesale-distribution' => [
        'title' => 'Wholesale & Distribution',
        'menu' => 'Bulk orders and client accounts',
        'icon' => 'fa-truck-ramp-box',
        'badge' => null,
        'headline' => 'Bulk orders and client accounts without the spreadsheets',
        'lead' => 'Take large orders, manage client pricing and credit, and move stock across warehouses with every invoice and payment recorded.',
        'description' => 'Zeebroo for wholesale and distribution: bulk orders, client accounts, credit and multi-warehouse stock.',
        'scene' => null,
        'highlights' => [
            ['fa-boxes-packing', 'Bulk orders', 'Build large orders quickly with quantities, units and client specific prices.'],
            ['fa-address-book', 'Client accounts', 'Track each client\'s orders, invoices, payments and outstanding balance.'],
            ['fa-warehouse', 'Many warehouses', 'See stock per location and transfer it where the orders are.'],
        ],
        'capabilities' => [
            'Sales orders and invoices for bulk quantities',
            'Client accounts with credit limits and balances',
            'Stock across multiple warehouses and branches',
            'Supplier purchases and stock receiving',
            'Payment collection and outstanding reports',
            'Sales by client, product and region',
        ],
        'modules' => ['sales-management', 'crm', 'multibranch', 'account-management'],
    ],

    'non-profit' => [
        'title' => 'Non-Profit',
        'menu' => 'Donations, campaigns and volunteers',
        'icon' => 'fa-hand-holding-heart',
        'badge' => null,
        'headline' => 'More time for the cause, less on the admin',
        'lead' => 'Record donations, run campaigns and events, and coordinate volunteers, with clear accounts you can share with donors and boards.',
        'description' => 'Zeebroo for non-profits: donations, campaigns, events, volunteers and transparent accounts.',
        'scene' => null,
        'highlights' => [
            ['fa-hand-holding-dollar', 'Donations recorded', 'Log every donation against its donor and campaign so nothing goes unthanked.'],
            ['fa-bullhorn', 'Campaigns and events', 'Plan fundraising campaigns and events and reach supporters by email and social.'],
            ['fa-people-group', 'Volunteers organised', 'Keep volunteer details, roles and schedules in one place.'],
        ],
        'capabilities' => [
            'Donor records and donation history',
            'Fundraising campaigns and events',
            'Email and social media outreach',
            'Volunteer and staff records',
            'Income and expense accounts per programme',
            'Reports ready for donors and boards',
        ],
        'modules' => ['crm', 'event-management', 'social-media-campaign', 'accounting'],
    ],

    'pharmacy-healthcare' => [
        'title' => 'Pharmacy & Healthcare',
        'menu' => 'Medicine stock and compliance',
        'icon' => 'fa-prescription-bottle-medical',
        'badge' => null,
        'headline' => 'Every batch and expiry date under control',
        'lead' => 'Dispense quickly at the counter, track medicines by batch and expiry, and keep clear records of what was sold and when.',
        'description' => 'Zeebroo for pharmacies and healthcare: batch and expiry tracking, fast dispensing and clear sales records.',
        'scene' => null,
        'highlights' => [
            ['fa-calendar-xmark', 'Expiry dates caught', 'Track batches and expiry dates so the oldest stock sells first and nothing expires on the shelf.'],
            ['fa-pills', 'Fast dispensing', 'Find medicines by brand or generic name and complete the sale in seconds.'],
            ['fa-clipboard-list', 'Clear records', 'Every sale, batch and stock movement is recorded with who did it and when.'],
        ],
        'capabilities' => [
            'Batch and expiry tracking',
            'Search by brand or generic name',
            'Low stock and near expiry alerts',
            'Supplier purchases and returns',
            'Customer records and purchase history',
            'Full history of sales and stock movements',
        ],
        'modules' => ['point-of-sale', 'stock-management', 'product-management', 'crm'],
    ],

    'hotel-hospitality' => [
        'title' => 'Hotel & Hospitality',
        'menu' => 'Rooms, billing and staff',
        'icon' => 'fa-bell-concierge',
        'badge' => null,
        'headline' => 'Rooms, restaurant and staff on one bill',
        'lead' => 'Manage bookings and guest bills, run the restaurant and bar from the same POS, and schedule your staff, all with one set of accounts.',
        'description' => 'Zeebroo for hotels and hospitality: rooms and guest billing, restaurant POS, staff and accounts.',
        'scene' => null,
        'highlights' => [
            ['fa-bed', 'Rooms and guests', 'Keep bookings and guest details together and see which rooms are ready.'],
            ['fa-file-invoice-dollar', 'One guest bill', 'Add room, restaurant and service charges to a single bill at checkout.'],
            ['fa-user-clock', 'Staff and shifts', 'Schedule housekeeping, front desk and kitchen staff and run payroll.'],
        ],
        'capabilities' => [
            'Room bookings and guest records',
            'Restaurant and bar POS charged to rooms',
            'Guest bills with room and service charges',
            'Housekeeping and staff schedules',
            'Events and function bookings',
            'Occupancy, revenue and expense reports',
        ],
        'modules' => ['services', 'restaurant', 'event-management', 'human-resources'],
    ],

];
