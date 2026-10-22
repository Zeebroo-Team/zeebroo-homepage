<?php

/*
|--------------------------------------------------------------------------
| API reference
|--------------------------------------------------------------------------
|
| The Zeebroo POS REST API shown at /docs/api, one page per resource. Each
| resource's body lives in resources/views/frontend/docs/api/resources/{slug}.blade.php;
| `endpoints` lists the cards inside it (anchor id => [method, path, name]) for
| the "On this page" menu and the overview search. A group's `title_si` and
| `description_si` replace its English ones when the website is in Sinhala;
| endpoint details stay in English, as they are read alongside code.
|
*/

return [

    'version' => 'v2.0.0',

    'endpoint_count' => 377,

    'groups' => [

        'foundation' => [
            'title' => 'Foundation — Auth, Catalog & Checkout',
            'label' => 'Pos API · 38 endpoints',
            'icon' => 'fa-key',
            'description' => 'Authentication, business/branch selection, the POS-optimized catalog, checkout, and core product/category/unit/brand/discount CRUD. Start here — everything else builds on these endpoints.',
            'title_si' => 'පදනම: පිවිසුම, නාමාවලිය සහ ගෙවීම්',
            'description_si' => 'පිවිසුම (auth), ව්‍යාපාර/ශාඛා තේරීම, POS සඳහා සකස් කළ නාමාවලිය, ගෙවීම් (checkout), සහ නිෂ්පාදන/කාණ්ඩ/ඒකක/වෙළඳ නාම/වට්ටම් සඳහා මූලික CRUD. මෙතැනින් පටන් ගන්න: අනෙක් සියලු endpoint මේවා මත පදනම් වේ.',
            'resources' => [
                'auth' => [
                    'title' => 'Authentication',
                    'description' => 'Token issuance, user registration, business-category lookups, profile, and token revocation. The public routes (token, register, business-categories) require no bearer token; the rest require one.',
                    'endpoints' => [
                        'ep-auth-token' => ['POST', '/api/v1/pos/auth/token', 'Create access token'],
                        'ep-auth-register' => ['POST', '/api/v1/pos/auth/register', 'Register user and create first business'],
                        'ep-auth-business-categories' => ['GET', '/api/v1/pos/auth/business-categories', 'List business category options'],
                        'ep-auth-me' => ['GET', '/api/v1/pos/auth/me', 'Get authenticated user profile'],
                        'ep-auth-revoke' => ['POST', '/api/v1/pos/auth/revoke', 'Revoke current token'],
                    ],
                ],
                'businesses' => [
                    'title' => 'Businesses',
                    'description' => 'Create and list businesses owned by, or accessible to, the current user — including businesses reached via HR employment or POS team membership.',
                    'endpoints' => [
                        'ep-businesses-list' => ['GET', '/api/v1/pos/businesses', 'List accessible businesses'],
                        'ep-businesses-store' => ['POST', '/api/v1/pos/businesses', 'Create a new business'],
                    ],
                ],
                'online-bootstrap' => [
                    'title' => 'Online Bootstrap',
                    'description' => 'Single call that loads everything the POS screen needs on startup — settings, categories, a page of products, payment accounts, today\'s summary, branches, and brands — so the client avoids multiple round trips.',
                    'endpoints' => [
                        'ep-online-bootstrap-index' => ['GET', '/api/v1/pos/online/bootstrap', 'Full POS bootstrap payload'],
                    ],
                ],
                'branches' => [
                    'title' => 'Branches',
                    'description' => 'Lists the branches available for the POS screen\'s branch switcher, gated on whether branch-level POS separation is enabled for the business.',
                    'endpoints' => [
                        'ep-branches-list' => ['GET', '/api/v1/pos/online/branches', 'List branches available for POS'],
                    ],
                ],
                'catalog' => [
                    'title' => 'Catalog (POS-optimized)',
                    'description' => 'Read-only product and category listings optimized for the POS screen — pagination, search, stock/branch filtering, SKU/barcode lookup, product detail, and stock-layer history.',
                    'endpoints' => [
                        'ep-catalog-categories' => ['GET', '/api/v1/pos/online/categories', 'List POS categories'],
                        'ep-catalog-products' => ['GET', '/api/v1/pos/online/products', 'Paginated product catalog for POS screen'],
                        'ep-catalog-show' => ['GET', '/api/v1/pos/online/products/{id}', 'Full product detail'],
                        'ep-catalog-sku' => ['GET', '/api/v1/pos/online/products/sku/{sku}', 'Look up product by SKU (barcode scan)'],
                        'ep-catalog-stock-history' => ['GET', '/api/v1/pos/online/products/{id}/stock-history', 'Product stock-layer receiving history'],
                    ],
                ],
                'checkout' => [
                    'title' => 'Checkout',
                    'description' => 'Creates a completed (or scheduled) sale from a cart of items, deducting stock and recording payment in one transaction.',
                    'endpoints' => [
                        'ep-checkout-store' => ['POST', '/api/v1/pos/online/checkout', 'Create a sale from cart items'],
                    ],
                ],
                'products' => [
                    'title' => 'Products',
                    'description' => 'Full product CRUD — quick-create, bulk import, update, and delete. Product creation is served under /online/products (same base path as the catalog read endpoints) via a quick-create flow that also accepts extended fields.',
                    'endpoints' => [
                        'ep-products-store' => ['POST', '/api/v1/pos/online/products', 'Create a product'],
                        'ep-products-import' => ['POST', '/api/v1/pos/online/products/import', 'Bulk import products'],
                        'ep-products-update' => ['PATCH', '/api/v1/pos/online/products/{product}', 'Update a product'],
                        'ep-products-destroy' => ['DELETE', '/api/v1/pos/online/products/{product}', 'Delete a product'],
                    ],
                ],
                'categories' => [
                    'title' => 'Categories',
                    'description' => 'Product category CRUD, including a parent-selector options endpoint for building nested category pickers.',
                    'endpoints' => [
                        'ep-categories-list' => ['GET', '/api/v1/pos/categories', 'List product categories'],
                        'ep-categories-store' => ['POST', '/api/v1/pos/categories', 'Create a category'],
                        'ep-categories-parent-options' => ['GET', '/api/v1/pos/categories/parent-options', 'Options list for parent category selector'],
                        'ep-categories-update' => ['PATCH', '/api/v1/pos/categories/{category}', 'Update a category'],
                        'ep-categories-destroy' => ['DELETE', '/api/v1/pos/categories/{category}', 'Delete a category'],
                    ],
                ],
                'units' => [
                    'title' => 'Units',
                    'description' => 'Product unit-of-measure CRUD (e.g. Piece, Box, Kilogram) used on the product form and selling-unit configuration.',
                    'endpoints' => [
                        'ep-units-list' => ['GET', '/api/v1/pos/units', 'List product units'],
                        'ep-units-store' => ['POST', '/api/v1/pos/units', 'Create a unit'],
                        'ep-units-update' => ['PATCH', '/api/v1/pos/units/{productUnit}', 'Update a unit'],
                        'ep-units-destroy' => ['DELETE', '/api/v1/pos/units/{productUnit}', 'Delete a unit'],
                    ],
                ],
                'brands' => [
                    'title' => 'Brands',
                    'description' => 'Product brand CRUD used on the product form and as a POS catalog filter.',
                    'endpoints' => [
                        'ep-brands-list' => ['GET', '/api/v1/pos/brands', 'List product brands'],
                        'ep-brands-store' => ['POST', '/api/v1/pos/brands', 'Create a brand'],
                        'ep-brands-update' => ['PATCH', '/api/v1/pos/brands/{brand}', 'Update a brand'],
                        'ep-brands-destroy' => ['DELETE', '/api/v1/pos/brands/{brand}', 'Delete a brand'],
                    ],
                ],
                'discounts' => [
                    'title' => 'Discounts',
                    'description' => 'Time-bounded, per-product discounts (flat amount or percentage) applied automatically at checkout while active.',
                    'endpoints' => [
                        'ep-discounts-list' => ['GET', '/api/v1/pos/discounts', 'List product discounts'],
                        'ep-discounts-store' => ['POST', '/api/v1/pos/discounts', 'Create a discount'],
                        'ep-discounts-product-options' => ['GET', '/api/v1/pos/discounts/product-options', 'Search products for discount form'],
                        'ep-discounts-update' => ['PATCH', '/api/v1/pos/discounts/{discount}', 'Update a discount'],
                        'ep-discounts-destroy' => ['DELETE', '/api/v1/pos/discounts/{discount}', 'Delete a discount'],
                    ],
                ],
                'sales-chart' => [
                    'title' => 'Product Sales Chart',
                    'description' => 'Bucketed sales-quantity series for a single product, used to render the sparkline/chart on the product detail panel.',
                    'endpoints' => [
                        'ep-sales-chart-show' => ['GET', '/api/v1/pos/online/products/{id}/sales-chart', 'Product sales chart data'],
                    ],
                ],
            ],
        ],

        'sales' => [
            'title' => 'Sales, Returns, Quotations & Invoices',
            'label' => 'Pos API · 33 endpoints',
            'icon' => 'fa-receipt',
            'description' => 'Sale history and void, refunds, and the full quotation and invoice lifecycles, plus customer and supplier records.',
            'title_si' => 'විකුණුම්, ආපසු භාරදීම්, මිල ගණන් පත්‍ර සහ ඉන්වොයිසි',
            'description_si' => 'විකුණුම් ඉතිහාසය සහ අවලංගු කිරීම, මුදල් ආපසු ගෙවීම්, මිල ගණන් පත්‍ර සහ ඉන්වොයිසිවල සම්පූර්ණ ක්‍රියාවලිය, සහ පාරිභෝගික හා සැපයුම්කරු වාර්තා.',
            'resources' => [
                'sales' => [
                    'title' => 'Sales',
                    'description' => 'Read and manage completed POS sales — search recent sales, pull a filterable sales history with summary and chart data, inspect a single sale, and void a sale.',
                    'endpoints' => [
                        'ep-sales-list' => ['GET', '/api/v1/pos/sales', 'List recent sales'],
                        'ep-sales-history' => ['GET', '/api/v1/pos/sales/history', 'Paginated sales history with summary and chart'],
                        'ep-sales-show' => ['GET', '/api/v1/pos/sales/{sale}', 'Get sale detail'],
                        'ep-sales-void' => ['POST', '/api/v1/pos/sales/{sale}/void', 'Void a sale'],
                    ],
                ],
                'sale-returns' => [
                    'title' => 'Sale Returns',
                    'description' => 'Process a refund against a completed sale — return one or more line items and settle the refund by cash, card, or store credit.',
                    'endpoints' => [
                        'ep-sale-returns-store' => ['POST', '/api/v1/pos/sales/{sale}/return', 'Process a sale return / refund'],
                    ],
                ],
                'return-reasons' => [
                    'title' => 'Return Reasons',
                    'description' => 'Static lookup of the return-reason options a client can present when submitting a sale return.',
                    'endpoints' => [
                        'ep-return-reasons-list' => ['GET', '/api/v1/pos/online/return-reasons', 'List return reason options'],
                    ],
                ],
                'quotations' => [
                    'title' => 'Quotations',
                    'description' => 'Full quotation lifecycle — create and edit line-item quotes, then move them through draft → sent → accepted/rejected.',
                    'endpoints' => [
                        'ep-quotations-list' => ['GET', '/api/v1/pos/quotations', 'List quotations'],
                        'ep-quotations-store' => ['POST', '/api/v1/pos/quotations', 'Create a quotation'],
                        'ep-quotations-show' => ['GET', '/api/v1/pos/quotations/{quotation}', 'Get quotation detail'],
                        'ep-quotations-update' => ['PATCH', '/api/v1/pos/quotations/{quotation}', 'Update a quotation'],
                        'ep-quotations-destroy' => ['DELETE', '/api/v1/pos/quotations/{quotation}', 'Delete a quotation'],
                        'ep-quotations-mark-sent' => ['POST', '/api/v1/pos/quotations/{quotation}/mark-sent', 'Mark quotation as sent'],
                        'ep-quotations-accept' => ['POST', '/api/v1/pos/quotations/{quotation}/accept', 'Mark quotation as accepted'],
                        'ep-quotations-reject' => ['POST', '/api/v1/pos/quotations/{quotation}/reject', 'Mark quotation as rejected'],
                    ],
                ],
                'invoices' => [
                    'title' => 'Invoices',
                    'description' => 'Full invoice lifecycle — create and edit line-item invoices, then move them through draft → sent → paid/overdue/cancelled.',
                    'endpoints' => [
                        'ep-invoices-list' => ['GET', '/api/v1/pos/invoices', 'List invoices'],
                        'ep-invoices-store' => ['POST', '/api/v1/pos/invoices', 'Create an invoice'],
                        'ep-invoices-show' => ['GET', '/api/v1/pos/invoices/{invoice}', 'Get invoice detail'],
                        'ep-invoices-update' => ['PATCH', '/api/v1/pos/invoices/{invoice}', 'Update an invoice'],
                        'ep-invoices-destroy' => ['DELETE', '/api/v1/pos/invoices/{invoice}', 'Delete an invoice'],
                        'ep-invoices-mark-sent' => ['POST', '/api/v1/pos/invoices/{invoice}/mark-sent', 'Mark invoice as sent'],
                        'ep-invoices-mark-paid' => ['POST', '/api/v1/pos/invoices/{invoice}/mark-paid', 'Mark invoice as paid'],
                        'ep-invoices-mark-overdue' => ['POST', '/api/v1/pos/invoices/{invoice}/mark-overdue', 'Mark invoice as overdue'],
                        'ep-invoices-cancel' => ['POST', '/api/v1/pos/invoices/{invoice}/cancel', 'Cancel an invoice'],
                    ],
                ],
                'customers' => [
                    'title' => 'Customers',
                    'description' => 'CRUD for POS customers, plus a detail view that includes each customer\'s most recent purchase history.',
                    'endpoints' => [
                        'ep-customers-list' => ['GET', '/api/v1/pos/customers', 'List customers'],
                        'ep-customers-store' => ['POST', '/api/v1/pos/customers', 'Create a customer'],
                        'ep-customers-show' => ['GET', '/api/v1/pos/customers/{customer}', 'Get customer detail with recent sales'],
                        'ep-customers-update' => ['PATCH', '/api/v1/pos/customers/{customer}', 'Update a customer'],
                        'ep-customers-destroy' => ['DELETE', '/api/v1/pos/customers/{customer}', 'Delete a customer'],
                    ],
                ],
                'suppliers' => [
                    'title' => 'Suppliers',
                    'description' => 'CRUD for purchasing suppliers used on POS purchase orders. Deleting a supplier soft-deactivates it rather than removing the record.',
                    'endpoints' => [
                        'ep-suppliers-list' => ['GET', '/api/v1/pos/suppliers', 'List suppliers'],
                        'ep-suppliers-store' => ['POST', '/api/v1/pos/suppliers', 'Create a supplier'],
                        'ep-suppliers-show' => ['GET', '/api/v1/pos/suppliers/{supplier}', 'Get supplier detail'],
                        'ep-suppliers-update' => ['PATCH', '/api/v1/pos/suppliers/{supplier}', 'Update a supplier'],
                        'ep-suppliers-destroy' => ['DELETE', '/api/v1/pos/suppliers/{supplier}', 'Deactivate supplier'],
                    ],
                ],
            ],
        ],

        'purchasing-finance' => [
            'title' => 'Purchasing & Finance',
            'label' => 'Pos API · 50 endpoints',
            'icon' => 'fa-building-columns',
            'description' => 'Supplier purchase orders through to goods receipt, cheque tracking, recurring/one-off expense bills, loans, rentals, properties, bank records, stock audits, and finance reporting.',
            'title_si' => 'මිලදී ගැනීම් සහ මූල්‍ය',
            'description_si' => 'සැපයුම්කරුවන්ට යවන මිලදී ගැනීමේ ඇණවුම් සිට භාණ්ඩ ලැබීම (GRN) දක්වා, චෙක්පත්, නිතිපතා/එක් වරක වියදම් බිල්පත්, ණය, කුලී, දේපළ, බැංකු වාර්තා, තොග විගණන සහ මූල්‍ය වාර්තා.',
            'resources' => [
                'purchase-orders' => [
                    'title' => 'Purchase Orders',
                    'description' => 'Create and manage purchase orders sent to suppliers — draft, place, receive, and cancel — via PosPurchaseOrderApiController.',
                    'endpoints' => [
                        'ep-purchase-orders-list' => ['GET', '/api/v1/pos/purchase-orders', 'List purchase orders'],
                        'ep-purchase-orders-store' => ['POST', '/api/v1/pos/purchase-orders', 'Create a purchase order'],
                        'ep-purchase-orders-show' => ['GET', '/api/v1/pos/purchase-orders/{purchase}', 'Get PO detail'],
                        'ep-purchase-orders-place' => ['POST', '/api/v1/pos/purchase-orders/{purchase}/place', 'Mark PO as ordered'],
                        'ep-purchase-orders-receive' => ['POST', '/api/v1/pos/purchase-orders/{purchase}/receive', 'Mark PO as received'],
                        'ep-purchase-orders-cancel' => ['POST', '/api/v1/pos/purchase-orders/{purchase}/cancel', 'Cancel a purchase order'],
                    ],
                ],
                'grns' => [
                    'title' => 'Goods Receive Notes',
                    'description' => 'Receive stock against a purchase order and track GRN payment status via PosGoodsReceiveNoteApiController.',
                    'endpoints' => [
                        'ep-grns-list' => ['GET', '/api/v1/pos/grns', 'List goods receive notes'],
                        'ep-grns-show' => ['GET', '/api/v1/pos/grns/{grn}', 'Get GRN detail'],
                        'ep-grns-create-form' => ['GET', '/api/v1/pos/purchase-orders/{purchase}/grn-form', 'Get GRN creation form data'],
                        'ep-grns-store' => ['POST', '/api/v1/pos/purchase-orders/{purchase}/grns', 'Create a GRN against a purchase order'],
                        'ep-grns-pay' => ['POST', '/api/v1/pos/grns/{grn}/pay', 'Record additional payment on a GRN'],
                    ],
                ],
                'grn-cheques' => [
                    'title' => 'GRN Cheques',
                    'description' => 'Track and clear cheque payments raised against GRNs via PosGrnChequeApiController.',
                    'endpoints' => [
                        'ep-grn-cheques-list' => ['GET', '/api/v1/pos/cheques', 'List cheque payments'],
                        'ep-grn-cheques-clear' => ['POST', '/api/v1/pos/cheques/{cheque}/clear', 'Clear a cheque'],
                    ],
                ],
                'expense-bills' => [
                    'title' => 'Expense Bills',
                    'description' => 'Create, view, pay, and delete recurring or one-time expense bills (utilities, rent-linked charges, etc.) via PosExpenseBillApiController.',
                    'endpoints' => [
                        'ep-expense-bills-store' => ['POST', '/api/v1/pos/expenses/bills', 'Create an expense bill'],
                        'ep-expense-bills-show' => ['GET', '/api/v1/pos/expenses/bills/{bill}', 'Get bill detail'],
                        'ep-expense-bills-pay' => ['POST', '/api/v1/pos/expenses/bills/{bill}/pay', 'Record a bill payment'],
                        'ep-expense-bills-destroy' => ['DELETE', '/api/v1/pos/expenses/bills/{bill}', 'Delete a bill'],
                    ],
                ],
                'expense-bill-list' => [
                    'title' => 'Expense Bill List',
                    'description' => 'Lightweight bill listing endpoint used to populate expense bill tables, served by PosExpenseBillListApiController (separate from the CRUD controller in Expense Bills).',
                    'endpoints' => [
                        'ep-expense-bill-list-index' => ['GET', '/api/v1/pos/expenses/bills', 'List all expense bills'],
                    ],
                ],
                'expense-bill-assignment' => [
                    'title' => 'Expense Bill Assignment',
                    'description' => 'Lookup endpoint that feeds the "assign this bill to…" picker on the create-bill form, served by PosExpenseBillAssignmentApiController.',
                    'endpoints' => [
                        'ep-expense-bill-assignment-targets' => ['GET', '/api/v1/pos/expenses/bill-assignment-targets', 'Get assignment target options'],
                    ],
                ],
                'expense-modifications' => [
                    'title' => 'Expense Modifications',
                    'description' => 'Track renovation and property-modification projects that bills can be assigned to, via PosExpenseModificationApiController.',
                    'endpoints' => [
                        'ep-expense-modifications-list' => ['GET', '/api/v1/pos/expenses/modifications', 'List expense modifications'],
                        'ep-expense-modifications-store' => ['POST', '/api/v1/pos/expenses/modifications', 'Create an expense modification'],
                        'ep-expense-modifications-show' => ['GET', '/api/v1/pos/expenses/modifications/{modification}', 'Get modification detail'],
                        'ep-expense-modifications-destroy' => ['DELETE', '/api/v1/pos/expenses/modifications/{modification}', 'Delete a modification'],
                    ],
                ],
                'expense-rental-list' => [
                    'title' => 'Expense Rental List',
                    'description' => 'Lightweight rental options list used to populate the "assign to rental" picker, served by PosExpenseRentalListApiController (distinct from the full Rentals CRUD endpoints).',
                    'endpoints' => [
                        'ep-expense-rental-list-index' => ['GET', '/api/v1/pos/expenses/rentals', 'List rentals for bill assignment'],
                    ],
                ],
                'expenses-overview' => [
                    'title' => 'Expenses Overview',
                    'description' => 'Aggregate dashboard combining bills, rentals, and modifications with a 12-month payment trend, served by PosExpensesOverviewApiController.',
                    'endpoints' => [
                        'ep-expenses-overview-show' => ['GET', '/api/v1/pos/expenses/overview', 'Get expenses overview'],
                    ],
                ],
                'end-of-day' => [
                    'title' => 'End of Day',
                    'description' => 'Review and settle unsettled cash/card sales to bank accounts, via PosEndOfDayApiController.',
                    'endpoints' => [
                        'ep-end-of-day-status' => ['GET', '/api/v1/pos/eod', 'EOD status'],
                        'ep-end-of-day-settle' => ['POST', '/api/v1/pos/eod/settle', 'Settle all unsettled sales'],
                    ],
                ],
                'finance-flow' => [
                    'title' => 'Finance Flow',
                    'description' => 'Combined monthly cash-outflow overview spanning bills, loans, and rentals, served by PosFinanceFlowApiController.',
                    'endpoints' => [
                        'ep-finance-flow-index' => ['GET', '/api/v1/pos/finance/flow', 'Get combined finance flow'],
                    ],
                ],
                'loans' => [
                    'title' => 'Loans',
                    'description' => 'Track business loans, their installment schedules, and repayments via PosLoanApiController.',
                    'endpoints' => [
                        'ep-loans-list' => ['GET', '/api/v1/pos/loans', 'List loans'],
                        'ep-loans-store' => ['POST', '/api/v1/pos/loans', 'Create a loan'],
                        'ep-loans-show' => ['GET', '/api/v1/pos/loans/{loan}', 'Get loan detail'],
                        'ep-loans-pay' => ['POST', '/api/v1/pos/loans/{loan}/pay', 'Record a loan installment payment'],
                        'ep-loans-destroy' => ['DELETE', '/api/v1/pos/loans/{loan}', 'Delete a loan'],
                    ],
                ],
                'properties' => [
                    'title' => 'Properties',
                    'description' => 'Track owned or leased business properties (buildings, land, equipment) and their expiry dates, via PosPropertyApiController.',
                    'endpoints' => [
                        'ep-properties-list' => ['GET', '/api/v1/pos/properties', 'List business properties'],
                        'ep-properties-store' => ['POST', '/api/v1/pos/properties', 'Create a property'],
                        'ep-properties-destroy' => ['DELETE', '/api/v1/pos/properties/{property}', 'Delete a property'],
                    ],
                ],
                'rentals' => [
                    'title' => 'Rentals',
                    'description' => 'Manage rental agreements, landlord contact records, and rent payments, via PosRentalApiController.',
                    'endpoints' => [
                        'ep-rentals-list' => ['GET', '/api/v1/pos/rentals', 'List rental agreements'],
                        'ep-rentals-store' => ['POST', '/api/v1/pos/rentals', 'Create a rental agreement'],
                        'ep-rentals-show' => ['GET', '/api/v1/pos/rentals/{rental}', 'Get rental detail'],
                        'ep-rentals-pay' => ['POST', '/api/v1/pos/rentals/{rental}/pay', 'Record a rent payment'],
                        'ep-rentals-destroy' => ['DELETE', '/api/v1/pos/rentals/{rental}', 'Delete a rental'],
                    ],
                ],
                'bank' => [
                    'title' => 'Bank',
                    'description' => 'Global bank lookup used by loan and account forms, served by PosBankApiController.',
                    'endpoints' => [
                        'ep-bank-list' => ['GET', '/api/v1/pos/banks', 'List all banks'],
                    ],
                ],
                'stock-audits' => [
                    'title' => 'Stock Audits',
                    'description' => 'Run physical stock counts, record variances against expected quantities, and finalize adjustments, via PosStockAuditApiController.',
                    'endpoints' => [
                        'ep-stock-audits-list' => ['GET', '/api/v1/pos/stock-audits', 'List stock audits'],
                        'ep-stock-audits-store' => ['POST', '/api/v1/pos/stock-audits', 'Create a stock audit'],
                        'ep-stock-audits-show' => ['GET', '/api/v1/pos/stock-audits/{stockAudit}', 'Get stock audit detail'],
                        'ep-stock-audits-save-lines' => ['PUT', '/api/v1/pos/stock-audits/{stockAudit}/lines', 'Save counted quantities'],
                        'ep-stock-audits-finalize' => ['POST', '/api/v1/pos/stock-audits/{stockAudit}/finalize', 'Finalize audit and apply adjustments'],
                        'ep-stock-audits-destroy' => ['DELETE', '/api/v1/pos/stock-audits/{stockAudit}', 'Delete a stock audit'],
                    ],
                ],
                'profit-report' => [
                    'title' => 'Profit Report',
                    'description' => 'Revenue, cost of goods sold, and net-profit reporting over a rolling period, served by PosProfitReportApiController.',
                    'endpoints' => [
                        'ep-profit-report-show' => ['GET', '/api/v1/pos/profit-report', 'Get profit report'],
                    ],
                ],
                'today-summary' => [
                    'title' => 'Today Summary',
                    'description' => 'Same-day sales and service-request snapshot for a POS dashboard, served by PosTodaySummaryApiController.',
                    'endpoints' => [
                        'ep-today-summary-show' => ['GET', '/api/v1/pos/today-summary', 'Get today\'s summary'],
                    ],
                ],
            ],
        ],

        'hr-payroll' => [
            'title' => 'HR & Payroll',
            'label' => 'Pos API · 30 endpoints',
            'icon' => 'fa-users',
            'description' => 'Payroll rule sets and cycles run from the POS side, plus read-only HR lookup lists (departments, employees, job titles, allowance types) used to populate POS-side forms.',
            'title_si' => 'මානව සම්පත් සහ වැටුප්',
            'description_si' => 'POS පැත්තෙන් ක්‍රියාත්මක වන වැටුප් නීති සහ වැටුප් චක්‍ර, සහ POS පෝරම පිරවීමට භාවිත වන කියවීමට පමණක් ඇති HR ලැයිස්තු (දෙපාර්තමේන්තු, සේවකයන්, තනතුරු, දීමනා වර්ග).',
            'resources' => [
                'payroll-rule-sets' => [
                    'title' => 'Payroll Rule Sets',
                    'description' => 'Configure per-business payroll rule sets — the container of calculation rules (earnings, deductions, statutory components) applied when a payroll cycle is computed — plus regional starter templates.',
                    'endpoints' => [
                        'ep-payroll-rule-sets-list' => ['GET', '/api/v1/pos/hr/payroll/rule-sets', 'List payroll rule sets'],
                        'ep-payroll-rule-sets-store' => ['POST', '/api/v1/pos/hr/payroll/rule-sets', 'Create a payroll rule set'],
                        'ep-payroll-rule-sets-show' => ['GET', '/api/v1/pos/hr/payroll/rule-sets/{ruleSet}', 'Get rule set detail with rules'],
                        'ep-payroll-rule-sets-update' => ['PATCH', '/api/v1/pos/hr/payroll/rule-sets/{ruleSet}', 'Update a rule set'],
                        'ep-payroll-rule-sets-destroy' => ['DELETE', '/api/v1/pos/hr/payroll/rule-sets/{ruleSet}', 'Delete a rule set'],
                        'ep-payroll-rule-sets-rule-store' => ['POST', '/api/v1/pos/hr/payroll/rule-sets/{ruleSet}/rules', 'Add a rule to a rule set'],
                        'ep-payroll-rule-sets-rule-update' => ['PATCH', '/api/v1/pos/hr/payroll/rule-sets/{ruleSet}/rules/{rule}', 'Update a payroll rule'],
                        'ep-payroll-rule-sets-rule-destroy' => ['DELETE', '/api/v1/pos/hr/payroll/rule-sets/{ruleSet}/rules/{rule}', 'Delete a payroll rule'],
                        'ep-payroll-rule-sets-templates-list' => ['GET', '/api/v1/pos/hr/payroll/templates', 'List regional payroll templates'],
                        'ep-payroll-rule-sets-templates-install' => ['POST', '/api/v1/pos/hr/payroll/templates/{key}/install', 'Install a regional payroll template'],
                    ],
                ],
                'payroll-cycles' => [
                    'title' => 'Payroll Cycles',
                    'description' => 'Create, compute, finalize, and pay monthly payroll cycles — each cycle runs a rule set against the business\'s employees to produce per-employee payroll items.',
                    'endpoints' => [
                        'ep-payroll-cycles-list' => ['GET', '/api/v1/pos/hr/payroll/cycles', 'List payroll cycles'],
                        'ep-payroll-cycles-store' => ['POST', '/api/v1/pos/hr/payroll/cycles', 'Create a payroll cycle'],
                        'ep-payroll-cycles-show' => ['GET', '/api/v1/pos/hr/payroll/cycles/{cycle}', 'Get cycle detail with items and summary'],
                        'ep-payroll-cycles-destroy' => ['DELETE', '/api/v1/pos/hr/payroll/cycles/{cycle}', 'Delete a payroll cycle'],
                        'ep-payroll-cycles-compute' => ['POST', '/api/v1/pos/hr/payroll/cycles/{cycle}/compute', 'Compute payroll for all employees in cycle'],
                        'ep-payroll-cycles-finalize' => ['POST', '/api/v1/pos/hr/payroll/cycles/{cycle}/finalize', 'Finalize a payroll cycle'],
                        'ep-payroll-cycles-payment' => ['POST', '/api/v1/pos/hr/payroll/cycles/{cycle}/payment', 'Record payroll payment'],
                        'ep-payroll-cycles-salary-sheet' => ['GET', '/api/v1/pos/hr/payroll/cycles/{cycle}/salary-sheet', 'Get formatted salary sheet for a cycle'],
                    ],
                ],
                'payroll-items' => [
                    'title' => 'Payroll Items',
                    'description' => 'Recompute a single employee\'s payroll item within a cycle with adjusted inputs, without re-running the whole cycle.',
                    'endpoints' => [
                        'ep-payroll-items-recompute' => ['POST', '/api/v1/pos/hr/payroll/cycles/{cycle}/items/{item}/recompute', 'Recompute a single employee payroll item'],
                    ],
                ],
                'payroll-overview' => [
                    'title' => 'Payroll Overview',
                    'description' => 'A single dashboard-style endpoint aggregating employee counts, department salary breakdown, payroll cycle status, a 12-month gross/net trend, and last-finalized-cycle KPIs including top earners.',
                    'endpoints' => [
                        'ep-payroll-overview-show' => ['GET', '/api/v1/pos/payroll-overview', 'Get payroll overview dashboard data'],
                    ],
                ],
                'hr-departments' => [
                    'title' => 'HR Departments (list)',
                    'description' => 'Read-only-oriented lookup list of HR departments, used to populate dropdowns on POS-side forms (e.g. the employee create form) and to manage the department catalog itself.',
                    'endpoints' => [
                        'ep-hr-departments-list' => ['GET', '/api/v1/pos/hr/departments', 'List departments'],
                        'ep-hr-departments-store' => ['POST', '/api/v1/pos/hr/departments', 'Create a department'],
                        'ep-hr-departments-destroy' => ['DELETE', '/api/v1/pos/hr/departments/{department}', 'Delete a department'],
                    ],
                ],
                'hr-employees' => [
                    'title' => 'HR Employees (list)',
                    'description' => 'List, view, and create HR employee records from the POS side, with inline creation of a new department or job title when needed.',
                    'endpoints' => [
                        'ep-hr-employees-list' => ['GET', '/api/v1/pos/hr/employees', 'List employees'],
                        'ep-hr-employees-store' => ['POST', '/api/v1/pos/hr/employees', 'Create an employee'],
                        'ep-hr-employees-show' => ['GET', '/api/v1/pos/hr/employees/{employee}', 'Get employee detail'],
                    ],
                ],
                'hr-job-titles' => [
                    'title' => 'HR Job Titles (list)',
                    'description' => 'Read-only lookup list of job titles for the current business, used to populate the job title dropdown on the POS-side employee create form.',
                    'endpoints' => [
                        'ep-hr-job-titles-list' => ['GET', '/api/v1/pos/hr/job-titles', 'List job titles'],
                    ],
                ],
                'hr-allowance-types' => [
                    'title' => 'HR Allowance Types',
                    'description' => 'Manage the catalog of named allowance types (e.g. transport, meal) that can be assigned to employees for payroll purposes.',
                    'endpoints' => [
                        'ep-hr-allowance-types-list' => ['GET', '/api/v1/pos/hr/allowance-types', 'List allowance types'],
                        'ep-hr-allowance-types-store' => ['POST', '/api/v1/pos/hr/allowance-types', 'Create an allowance type'],
                        'ep-hr-allowance-types-destroy' => ['DELETE', '/api/v1/pos/hr/allowance-types/{allowanceType}', 'Delete an allowance type'],
                    ],
                ],
            ],
        ],

        'crm-mail' => [
            'title' => 'CRM & Mail',
            'label' => 'Pos API · 49 endpoints',
            'icon' => 'fa-envelope-open-text',
            'description' => 'Lead/pipeline/contact/task management (CRM) and inbox/message handling (Mail), both scoped to the current business.',
            'title_si' => 'CRM සහ තැපෑල',
            'description_si' => 'ඊයම් (lead), විකුණුම් නල මාර්ග, සම්බන්ධතා සහ කාර්ය කළමනාකරණය (CRM) සහ එන ලිපි/පණිවිඩ හැසිරවීම (Mail). දෙකම වත්මන් ව්‍යාපාරයට සීමා වේ.',
            'resources' => [
                'crm' => [
                    'title' => 'CRM',
                    'description' => 'Lightweight CRM built on projects (pipelines): leads move through customizable stages, projects can expose public lead-capture forms with custom fields, and tasks/contacts round out day-to-day follow-up. Stage-entry and lead-created email flows are configured in the Automation Editor.',
                    'endpoints' => [
                        'ep-crm-projects-list' => ['GET', '/api/v1/pos/crm/projects', 'List projects'],
                        'ep-crm-projects-store' => ['POST', '/api/v1/pos/crm/projects', 'Create project'],
                        'ep-crm-pipeline' => ['GET', '/api/v1/pos/crm/projects/{project}/pipeline', 'Get pipeline board'],
                        'ep-crm-leads-store' => ['POST', '/api/v1/pos/crm/projects/{project}/leads', 'Create lead'],
                        'ep-crm-leads-update' => ['PUT', '/api/v1/pos/crm/leads/{lead}', 'Update lead'],
                        'ep-crm-leads-move-stage' => ['POST', '/api/v1/pos/crm/leads/{lead}/move-stage', 'Move lead to another stage'],
                        'ep-crm-leads-destroy' => ['DELETE', '/api/v1/pos/crm/leads/{lead}', 'Delete lead'],
                        'ep-crm-stages-list' => ['GET', '/api/v1/pos/crm/projects/{project}/stages', 'List stages'],
                        'ep-crm-stages-store' => ['POST', '/api/v1/pos/crm/projects/{project}/stages', 'Create stage'],
                        'ep-crm-stages-reorder' => ['POST', '/api/v1/pos/crm/projects/{project}/stages/reorder', 'Reorder stages'],
                        'ep-crm-stages-update' => ['PUT', '/api/v1/pos/crm/projects/{project}/stages/{stage}', 'Update stage'],
                        'ep-crm-stages-destroy' => ['DELETE', '/api/v1/pos/crm/projects/{project}/stages/{stage}', 'Delete stage'],
                        'ep-crm-contacts-list' => ['GET', '/api/v1/pos/crm/contacts', 'List contacts'],
                        'ep-crm-tasks-list' => ['GET', '/api/v1/pos/crm/tasks', 'List tasks'],
                        'ep-crm-tasks-store' => ['POST', '/api/v1/pos/crm/tasks', 'Create task'],
                        'ep-crm-tasks-complete' => ['POST', '/api/v1/pos/crm/tasks/{task}/complete', 'Complete task'],
                        'ep-crm-tasks-reopen' => ['POST', '/api/v1/pos/crm/tasks/{task}/reopen', 'Reopen task'],
                        'ep-crm-tasks-destroy' => ['DELETE', '/api/v1/pos/crm/tasks/{task}', 'Delete task'],
                        'ep-crm-forms-list' => ['GET', '/api/v1/pos/crm/projects/{project}/forms', 'List forms'],
                        'ep-crm-forms-store' => ['POST', '/api/v1/pos/crm/projects/{project}/forms', 'Create form'],
                        'ep-crm-forms-show' => ['GET', '/api/v1/pos/crm/projects/{project}/forms/{form}', 'Get form (builder detail)'],
                        'ep-crm-forms-update' => ['PUT', '/api/v1/pos/crm/projects/{project}/forms/{form}', 'Update form'],
                        'ep-crm-forms-publish' => ['POST', '/api/v1/pos/crm/projects/{project}/forms/{form}/publish', 'Publish form'],
                        'ep-crm-forms-unpublish' => ['POST', '/api/v1/pos/crm/projects/{project}/forms/{form}/unpublish', 'Unpublish form'],
                        'ep-crm-forms-destroy' => ['DELETE', '/api/v1/pos/crm/projects/{project}/forms/{form}', 'Delete form'],
                        'ep-crm-form-templates' => ['GET', '/api/v1/pos/crm/form-templates', 'List form templates'],
                        'ep-crm-custom-fields-list' => ['GET', '/api/v1/pos/crm/projects/{project}/custom-fields', 'List custom fields'],
                        'ep-crm-custom-fields-store' => ['POST', '/api/v1/pos/crm/projects/{project}/custom-fields', 'Create custom field'],
                    ],
                ],
                'mail' => [
                    'title' => 'Mail',
                    'description' => 'Business email inbox: threaded conversations grouped by counterpart address, individual message management, sending (including scheduled sends), reusable templates, inbound filters, and mail provider settings (platform, SMTP, or Resend).',
                    'endpoints' => [
                        'ep-mail-threads-list' => ['GET', '/api/v1/pos/mail/threads', 'List conversation threads'],
                        'ep-mail-thread-show' => ['GET', '/api/v1/pos/mail/thread', 'Get thread timeline'],
                        'ep-mail-messages-list' => ['GET', '/api/v1/pos/mail/messages', 'List messages'],
                        'ep-mail-messages-show' => ['GET', '/api/v1/pos/mail/messages/{message}', 'Get message'],
                        'ep-mail-messages-read' => ['POST', '/api/v1/pos/mail/messages/{message}/read', 'Mark message read'],
                        'ep-mail-send' => ['POST', '/api/v1/pos/mail/send', 'Send (or schedule) an email'],
                        'ep-mail-templates-list' => ['GET', '/api/v1/pos/mail/templates', 'List mail templates'],
                        'ep-mail-templates-store' => ['POST', '/api/v1/pos/mail/templates', 'Create mail template'],
                        'ep-mail-templates-destroy' => ['DELETE', '/api/v1/pos/mail/templates/{template}', 'Delete mail template'],
                        'ep-mail-scheduled-list' => ['GET', '/api/v1/pos/mail/scheduled', 'List scheduled emails'],
                        'ep-mail-scheduled-destroy' => ['DELETE', '/api/v1/pos/mail/scheduled/{scheduledMail}', 'Cancel scheduled email'],
                        'ep-mail-filters-list' => ['GET', '/api/v1/pos/mail/filters', 'List inbound mail filters'],
                        'ep-mail-settings-show' => ['GET', '/api/v1/pos/mail/settings', 'Get mail settings'],
                        'ep-mail-settings-update' => ['PATCH', '/api/v1/pos/mail/settings', 'Update mail settings'],
                        'ep-mail-sync' => ['POST', '/api/v1/pos/mail/sync', 'Sync mailbox now'],
                        'ep-mail-test' => ['POST', '/api/v1/pos/mail/test', 'Send test email'],
                        'ep-mail-verify-credentials' => ['POST', '/api/v1/pos/mail/verify-credentials', 'Verify mail provider credentials'],
                    ],
                ],
            ],
        ],

        'operations' => [
            'title' => 'Cashiers, Users & Registers',
            'label' => 'Pos API · 27 endpoints',
            'icon' => 'fa-cash-register',
            'description' => 'Day-to-day POS terminal operations: cashiers, POS-side user and role management, counters, cash drawer tracking, register locking, deposit accounts, and file uploads.',
            'title_si' => 'මුදල් අයකරුවන්, පරිශීලකයන් සහ කවුන්ටර',
            'description_si' => 'දිනපතා POS මෙහෙයුම්: මුදල් අයකරුවන්, POS පරිශීලක සහ භූමිකා කළමනාකරණය, කවුන්ටර, මුදල් ලාච්චුව, රෙජිස්ටර් අගුළු දැමීම, තැන්පතු ගිණුම් සහ ගොනු උඩුගත කිරීම.',
            'resources' => [
                'cashiers' => [
                    'title' => 'Cashiers',
                    'description' => 'POS cashier login accounts used for shared terminals — lightweight username/password accounts scoped to a business, separate from platform user accounts. Cashiers authenticate through a dedicated login endpoint that issues their own Sanctum token.',
                    'endpoints' => [
                        'ep-cashiers-login' => ['POST', '/api/v1/pos/cashier/login', 'Cashier login'],
                        'ep-cashiers-list' => ['GET', '/api/v1/pos/cashiers', 'List cashiers'],
                        'ep-cashiers-store' => ['POST', '/api/v1/pos/cashiers', 'Create cashier'],
                        'ep-cashiers-update' => ['PATCH', '/api/v1/pos/cashiers/{cashier}', 'Update cashier'],
                        'ep-cashiers-destroy' => ['DELETE', '/api/v1/pos/cashiers/{cashier}', 'Delete cashier'],
                    ],
                ],
                'user-management' => [
                    'title' => 'User Management',
                    'description' => 'Manage which platform user accounts can access the current business — the owner plus invited members and their role/permission overrides — and resolve the current session\'s own effective permissions via /me. This is POS-side staff access management, distinct from Cashiers (terminal-only logins with no platform account) and from the platform\'s global admin user accounts.',
                    'endpoints' => [
                        'ep-user-management-me' => ['GET', '/api/v1/pos/me', 'Current session permissions'],
                        'ep-user-management-list' => ['GET', '/api/v1/pos/users', 'List business users'],
                        'ep-user-management-store' => ['POST', '/api/v1/pos/users', 'Add business user'],
                        'ep-user-management-update' => ['PUT', '/api/v1/pos/users/{member}', 'Update business user'],
                        'ep-user-management-destroy' => ['DELETE', '/api/v1/pos/users/{member}', 'Remove business user'],
                    ],
                ],
                'role-management' => [
                    'title' => 'Role Management',
                    'description' => 'Custom, per-business roles that bundle permission sets, layered on top of the three built-in system roles — admin, manager, staff — which are seeded automatically for every business the first time roles are accessed.',
                    'endpoints' => [
                        'ep-role-management-list' => ['GET', '/api/v1/pos/roles', 'List roles'],
                        'ep-role-management-store' => ['POST', '/api/v1/pos/roles', 'Create role'],
                        'ep-role-management-update' => ['PUT', '/api/v1/pos/roles/{role}', 'Update role'],
                        'ep-role-management-destroy' => ['DELETE', '/api/v1/pos/roles/{role}', 'Delete role'],
                    ],
                ],
                'counters' => [
                    'title' => 'Counters',
                    'description' => 'POS terminal/counter registration — the physical or virtual checkout counters a business can open sales sessions against, optionally scoped to a branch when branch-level POS separation is in use.',
                    'endpoints' => [
                        'ep-counters-list' => ['GET', '/api/v1/pos/counters', 'List counters'],
                        'ep-counters-store' => ['POST', '/api/v1/pos/counters', 'Create counter'],
                        'ep-counters-update' => ['PATCH', '/api/v1/pos/counters/{counter}', 'Update counter'],
                        'ep-counters-destroy' => ['DELETE', '/api/v1/pos/counters/{counter}', 'Delete counter'],
                    ],
                ],
                'cash-drawer' => [
                    'title' => 'Cash Drawer',
                    'description' => 'Daily cash register float tracking — record today\'s opening float, log cash withdrawals through the day, and read back a computed running balance against completed cash sales.',
                    'endpoints' => [
                        'ep-cash-drawer-status' => ['GET', '/api/v1/pos/cash-drawer', 'Today\'s drawer status'],
                        'ep-cash-drawer-open' => ['POST', '/api/v1/pos/cash-drawer/open', 'Set opening float'],
                        'ep-cash-drawer-withdraw' => ['POST', '/api/v1/pos/cash-drawer/withdraw', 'Log withdrawal'],
                    ],
                ],
                'register-lock' => [
                    'title' => 'Register Lock',
                    'description' => 'Single endpoint backing the POS register-lock screen — re-verifies the current session\'s own password to unlock a terminal that was locked mid-session, without forcing a full re-login.',
                    'endpoints' => [
                        'ep-register-lock-verify' => ['POST', '/api/v1/pos/verify-password', 'Verify password'],
                    ],
                ],
                'pos-accounts' => [
                    'title' => 'Deposit Accounts',
                    'description' => 'Bank/deposit accounts that POS sales and payments get credited to (operating, savings, petty cash, payroll, etc.) — not user login accounts. Includes the bank-type lookup used to populate the account creation form.',
                    'endpoints' => [
                        'ep-pos-accounts-list' => ['GET', '/api/v1/pos/accounts', 'List deposit accounts'],
                        'ep-pos-accounts-bank-types' => ['GET', '/api/v1/pos/bank-types', 'List bank types'],
                        'ep-pos-accounts-store' => ['POST', '/api/v1/pos/accounts', 'Create deposit account'],
                    ],
                ],
                'file-manager' => [
                    'title' => 'File Manager',
                    'description' => 'Business-scoped file/folder browser and uploader backing the desktop client\'s image and document picker (product images, design assets, and similar attachments).',
                    'endpoints' => [
                        'ep-file-manager-browse' => ['GET', '/api/v1/pos/online/file-manager', 'Browse files and folders'],
                        'ep-file-manager-upload' => ['POST', '/api/v1/pos/online/file-manager/upload', 'Upload files'],
                    ],
                ],
            ],
        ],

        'design-services' => [
            'title' => 'Services & Design Studio',
            'label' => 'Pos API · 34 endpoints',
            'icon' => 'fa-palette',
            'description' => 'Bookable/appointment-style services, the marketing Design Studio campaign builder, AI-assisted design and guide chat, and POS-level settings.',
            'title_si' => 'සේවා සහ ඩිසයින් ස්ටූඩියෝ',
            'description_si' => 'වෙන්කරවා ගත හැකි/හමුවීම් ආකාර සේවා, ඩිසයින් ස්ටූඩියෝ ප්‍රචාරණ නිර්මාණකරු, AI සහාය ඇති නිර්මාණ සහ මාර්ගෝපදේශ චැට්, සහ POS සැකසුම්.',
            'resources' => [
                'services' => [
                    'title' => 'Services',
                    'description' => 'Catalog and workflow for bookable/appointment-style services (as opposed to physical products) — service items, categories, employee/product assignment, and customer service requests.',
                    'endpoints' => [
                        'ep-services-catalog-index' => ['GET', '/api/v1/pos/service/catalog', 'List service catalog'],
                        'ep-services-catalog-store' => ['POST', '/api/v1/pos/service/catalog', 'Create service item'],
                        'ep-services-catalog-show' => ['GET', '/api/v1/pos/service/catalog/{serviceItem}', 'Get service item'],
                        'ep-services-catalog-update' => ['PATCH', '/api/v1/pos/service/catalog/{serviceItem}', 'Update service item'],
                        'ep-services-catalog-destroy' => ['DELETE', '/api/v1/pos/service/catalog/{serviceItem}', 'Delete service item'],
                        'ep-services-catalog-employees-sync' => ['PUT', '/api/v1/pos/service/catalog/{serviceItem}/employees', 'Sync assigned employees'],
                        'ep-services-catalog-products-sync' => ['PUT', '/api/v1/pos/service/catalog/{serviceItem}/products', 'Sync consumed products'],
                        'ep-services-categories-index' => ['GET', '/api/v1/pos/service/categories', 'List service categories'],
                        'ep-services-categories-store' => ['POST', '/api/v1/pos/service/categories', 'Create service category'],
                        'ep-services-categories-destroy' => ['DELETE', '/api/v1/pos/service/categories/{serviceCategory}', 'Delete service category'],
                        'ep-services-requests-index' => ['GET', '/api/v1/pos/service/requests', 'List service requests'],
                        'ep-services-requests-store' => ['POST', '/api/v1/pos/service/requests', 'Create service request'],
                        'ep-services-requests-status' => ['PATCH', '/api/v1/pos/service/requests/{serviceRequest}/status', 'Update request status'],
                    ],
                ],
                'design-studio' => [
                    'title' => 'Design Studio',
                    'description' => 'Marketing/graphic design campaign builder — Fabric.js canvas documents (letterheads, business cards, posters) plus a multi-page "project proposal" workflow with AI-generated content.',
                    'endpoints' => [
                        'ep-design-studio-designs-index' => ['GET', '/api/v1/pos/design-studio/designs', 'List designs'],
                        'ep-design-studio-designs-store' => ['POST', '/api/v1/pos/design-studio/designs', 'Create design canvas'],
                        'ep-design-studio-designs-show' => ['GET', '/api/v1/pos/design-studio/designs/{design}', 'Get design'],
                        'ep-design-studio-designs-update' => ['PATCH', '/api/v1/pos/design-studio/designs/{design}', 'Update design (save canvas)'],
                        'ep-design-studio-designs-destroy' => ['DELETE', '/api/v1/pos/design-studio/designs/{design}', 'Delete design'],
                        'ep-design-studio-proposals-index' => ['GET', '/api/v1/pos/design-studio/proposals', 'List project proposals'],
                        'ep-design-studio-proposals-store' => ['POST', '/api/v1/pos/design-studio/proposals', 'Create project proposal'],
                        'ep-design-studio-proposals-ai-content' => ['POST', '/api/v1/pos/design-studio/proposals/ai-content', 'Generate proposal content (AI, preview)'],
                        'ep-design-studio-proposals-destroy' => ['DELETE', '/api/v1/pos/design-studio/proposals/{group}', 'Delete proposal'],
                        'ep-design-studio-proposals-ai-fill' => ['POST', '/api/v1/pos/design-studio/proposals/{group}/ai-fill', 'Fill proposal with AI content'],
                        'ep-design-studio-proposals-link-invoice' => ['POST', '/api/v1/pos/design-studio/proposals/{group}/link-invoice', 'Link proposal to invoice'],
                        'ep-design-studio-proposals-add-page' => ['POST', '/api/v1/pos/design-studio/proposals/{group}/pages', 'Add proposal page'],
                        'ep-design-studio-proposals-pages' => ['GET', '/api/v1/pos/design-studio/proposals/{group}/pages', 'Get proposal pages'],
                    ],
                ],
                'design-ai-chat' => [
                    'title' => 'Design AI Chat',
                    'description' => 'Conversational AI assistant embedded in the Design Studio canvas editor — turns a natural-language request into a sequence of Fabric.js draw commands (shapes, text, styling) the frontend replays onto the canvas.',
                    'endpoints' => [
                        'ep-design-ai-chat-chat' => ['POST', '/api/v1/pos/design-studio/ai-chat', 'Design AI chat'],
                    ],
                ],
                'guide-chat' => [
                    'title' => 'Guide Chat',
                    'description' => 'In-app animated help assistant ("Zeebroo Guide") that answers questions about using the app, triggers on-screen UI walkthroughs, and answers live business-data questions.',
                    'endpoints' => [
                        'ep-guide-chat-chat' => ['POST', '/api/v1/pos/guide/chat', 'Guide chat'],
                    ],
                ],
                'pos-settings' => [
                    'title' => 'POS Settings',
                    'description' => 'Business-level POS configuration — feature toggles, checkout/receipt/tax/branch settings, and a lightweight sync-status endpoint used by the desktop client to detect stale local caches.',
                    'endpoints' => [
                        'ep-pos-settings-features' => ['GET', '/api/v1/pos/online/features', 'Get enabled features'],
                        'ep-pos-settings-features-update' => ['PUT', '/api/v1/pos/online/features', 'Update enabled features'],
                        'ep-pos-settings-settings-show' => ['GET', '/api/v1/pos/online/settings', 'Get POS settings'],
                        'ep-pos-settings-settings-update' => ['PUT', '/api/v1/pos/online/settings', 'Update POS settings (full replace)'],
                        'ep-pos-settings-settings-patch' => ['PATCH', '/api/v1/pos/online/settings', 'Update POS settings (partial)'],
                        'ep-pos-settings-sync-status' => ['GET', '/api/v1/pos/online/sync-status', 'Get sync status'],
                    ],
                ],
            ],
        ],

        'restaurant' => [
            'title' => 'Restaurant',
            'label' => 'Other modules · 43 endpoints',
            'icon' => 'fa-utensils',
            'description' => 'Tables, menu categories and items, ingredient stock and purchasing, and order management for the restaurant/table-service experience.',
            'title_si' => 'අවන්හල',
            'description_si' => 'මේස, මෙනු කාණ්ඩ සහ අයිතම, අමුද්‍රව්‍ය තොග සහ මිලදී ගැනීම්, සහ අවන්හල්/මේස සේවාව සඳහා ඇණවුම් කළමනාකරණය.',
            'resources' => [
                'orders' => [
                    'title' => 'Orders',
                    'description' => 'Dine-in, takeaway, and delivery order lifecycle — create orders, manage line items and kitchen statuses, transition order status, and settle a completed order into a POS sale. Business scope is resolved from the authenticated user\'s currently session-selected business, not an X-Business-Id header.',
                    'endpoints' => [
                        'ep-orders-index' => ['GET', '/api/v1/pos/restaurant/orders', 'List orders'],
                        'ep-orders-store' => ['POST', '/api/v1/pos/restaurant/orders', 'Create order'],
                        'ep-orders-bootstrap' => ['GET', '/api/v1/pos/restaurant/orders/bootstrap', 'Order screen bootstrap data'],
                        'ep-orders-item-statuses' => ['GET', '/api/v1/pos/restaurant/orders/item-statuses', 'Poll order item statuses'],
                        'ep-orders-show' => ['GET', '/api/v1/pos/restaurant/orders/{order}', 'Get order'],
                        'ep-orders-transition' => ['PATCH', '/api/v1/pos/restaurant/orders/{order}/status', 'Transition order status'],
                        'ep-orders-add-items' => ['POST', '/api/v1/pos/restaurant/orders/{order}/items', 'Add items to order'],
                        'ep-orders-item-status' => ['PATCH', '/api/v1/pos/restaurant/orders/{order}/items/{item}/status', 'Update order item status'],
                        'ep-orders-delete-item' => ['DELETE', '/api/v1/pos/restaurant/orders/{order}/items/{item}', 'Remove order item'],
                        'ep-orders-complete' => ['POST', '/api/v1/pos/restaurant/orders/{order}/complete', 'Complete and pay order'],
                        'ep-orders-clear' => ['DELETE', '/api/v1/pos/restaurant/orders/{order}', 'Clear (void) order'],
                    ],
                ],
                'menu-items' => [
                    'title' => 'Menu Items',
                    'description' => 'CRUD for menu items sold through the restaurant module, plus availability toggling and per-item recipe (ingredient) management used to auto-deduct stock when an order is served.',
                    'endpoints' => [
                        'ep-menu-items-index' => ['GET', '/api/v1/pos/restaurant/menu-items', 'List menu items'],
                        'ep-menu-items-store' => ['POST', '/api/v1/pos/restaurant/menu-items', 'Create menu item'],
                        'ep-menu-items-show' => ['GET', '/api/v1/pos/restaurant/menu-items/{menuItem}', 'Get menu item'],
                        'ep-menu-items-update' => ['PUT', '/api/v1/pos/restaurant/menu-items/{menuItem}', 'Update menu item'],
                        'ep-menu-items-destroy' => ['DELETE', '/api/v1/pos/restaurant/menu-items/{menuItem}', 'Delete menu item'],
                        'ep-menu-items-toggle' => ['PATCH', '/api/v1/pos/restaurant/menu-items/{menuItem}/toggle', 'Toggle availability'],
                        'ep-menu-items-ingredients-list' => ['GET', '/api/v1/pos/restaurant/menu-items/{menuItem}/ingredients', 'Get menu item recipe'],
                        'ep-menu-items-ingredients-sync' => ['PUT', '/api/v1/pos/restaurant/menu-items/{menuItem}/ingredients', 'Set menu item recipe'],
                    ],
                ],
                'menu-categories' => [
                    'title' => 'Menu Categories',
                    'description' => 'Menu category management for grouping menu items, including manual drag-reordering.',
                    'endpoints' => [
                        'ep-menu-categories-index' => ['GET', '/api/v1/pos/restaurant/menu-categories', 'List menu categories'],
                        'ep-menu-categories-store' => ['POST', '/api/v1/pos/restaurant/menu-categories', 'Create menu category'],
                        'ep-menu-categories-reorder' => ['POST', '/api/v1/pos/restaurant/menu-categories/reorder', 'Reorder menu categories'],
                        'ep-menu-categories-update' => ['PUT', '/api/v1/pos/restaurant/menu-categories/{menuCategory}', 'Update menu category'],
                        'ep-menu-categories-destroy' => ['DELETE', '/api/v1/pos/restaurant/menu-categories/{menuCategory}', 'Delete menu category'],
                    ],
                ],
                'ingredients' => [
                    'title' => 'Ingredients',
                    'description' => 'Raw ingredient inventory used in menu item recipes — stock levels, manual stock-in, and the stock transaction ledger. Stock is also moved automatically by recipe deduction (order served) and purchase GRNs.',
                    'endpoints' => [
                        'ep-ingredients-index' => ['GET', '/api/v1/pos/restaurant/ingredients', 'List ingredients'],
                        'ep-ingredients-store' => ['POST', '/api/v1/pos/restaurant/ingredients', 'Create ingredient'],
                        'ep-ingredients-update' => ['PUT', '/api/v1/pos/restaurant/ingredients/{ingredient}', 'Update ingredient'],
                        'ep-ingredients-destroy' => ['DELETE', '/api/v1/pos/restaurant/ingredients/{ingredient}', 'Delete ingredient'],
                        'ep-ingredients-stock-in' => ['POST', '/api/v1/pos/restaurant/ingredients/{ingredient}/stock-in', 'Manual stock-in'],
                        'ep-ingredients-transactions' => ['GET', '/api/v1/pos/restaurant/ingredients/{ingredient}/transactions', 'List stock transactions'],
                    ],
                ],
                'ingredient-purchases' => [
                    'title' => 'Ingredient Purchases',
                    'description' => 'Purchase orders for restocking ingredients from suppliers — draft/order/cancel a PO, and record goods-received notes (GRNs) that post received quantities into ingredient stock and update the PO\'s receipt status.',
                    'endpoints' => [
                        'ep-ingredient-purchases-index' => ['GET', '/api/v1/pos/restaurant/purchase-orders', 'List purchase orders'],
                        'ep-ingredient-purchases-store' => ['POST', '/api/v1/pos/restaurant/purchase-orders', 'Create purchase order'],
                        'ep-ingredient-purchases-show' => ['GET', '/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}', 'Get purchase order'],
                        'ep-ingredient-purchases-update' => ['PUT', '/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}', 'Update purchase order'],
                        'ep-ingredient-purchases-destroy' => ['DELETE', '/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}', 'Delete purchase order'],
                        'ep-ingredient-purchases-place-order' => ['POST', '/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}/place-order', 'Place order'],
                        'ep-ingredient-purchases-cancel' => ['POST', '/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}/cancel', 'Cancel purchase order'],
                        'ep-ingredient-purchases-grn' => ['POST', '/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}/grn', 'Record goods received (GRN)'],
                    ],
                ],
                'tables' => [
                    'title' => 'Tables',
                    'description' => 'Dining table management — capacity, live occupancy status, and floor-plan (x/y) positions used by the visual table layout view.',
                    'endpoints' => [
                        'ep-tables-index' => ['GET', '/api/v1/pos/restaurant/tables', 'List tables'],
                        'ep-tables-store' => ['POST', '/api/v1/pos/restaurant/tables', 'Create table'],
                        'ep-tables-positions' => ['POST', '/api/v1/pos/restaurant/tables/positions', 'Save table floor-plan positions'],
                        'ep-tables-update' => ['PUT', '/api/v1/pos/restaurant/tables/{restaurantTable}', 'Update table'],
                        'ep-tables-destroy' => ['DELETE', '/api/v1/pos/restaurant/tables/{restaurantTable}', 'Delete table'],
                    ],
                ],
            ],
        ],

        'developers-projects' => [
            'title' => 'Developers & Project Management',
            'label' => 'Other modules · 36 endpoints',
            'icon' => 'fa-code',
            'description' => 'API keys and webhooks for third-party integrations, plus the internal project/task/board/milestone tracker.',
            'title_si' => 'සංවර්ධකයින් සහ ව්‍යාපෘති කළමනාකරණය',
            'description_si' => 'තෙවන පාර්ශ්ව සම්බන්ධතා සඳහා API යතුරු සහ webhooks, සහ අභ්‍යන්තර ව්‍යාපෘති/කාර්ය/පුවරු/සන්ධිස්ථාන ලුහුබැඳීම.',
            'resources' => [
                'developer-api-keys' => [
                    'title' => 'Developer API Keys',
                    'description' => 'Issue, list, toggle, and revoke API keys that let third-party integrations authenticate against the platform on behalf of a business. Keys are business-scoped and stored only as a SHA-256 hash — the raw token is returned exactly once, at creation time. DeveloperApiKeyApiController is mounted twice, under both the standalone /api/v1/developers prefix and the /api/v1/pos prefix, with identical behavior on each.',
                    'endpoints' => [
                        'ep-developer-api-keys-index' => ['GET', '/api/v1/developers/keys', 'List API keys'],
                        'ep-developer-api-keys-store' => ['POST', '/api/v1/developers/keys', 'Create API key'],
                        'ep-developer-api-keys-toggle' => ['PATCH', '/api/v1/developers/keys/{id}/toggle', 'Toggle API key active state'],
                        'ep-developer-api-keys-destroy' => ['DELETE', '/api/v1/developers/keys/{id}', 'Revoke API key'],
                        'ep-developer-api-keys-index-pos' => ['GET', '/api/v1/pos/developers/keys', 'List API keys (POS-prefixed mount)'],
                        'ep-developer-api-keys-store-pos' => ['POST', '/api/v1/pos/developers/keys', 'Create API key (POS-prefixed mount)'],
                        'ep-developer-api-keys-toggle-pos' => ['PATCH', '/api/v1/pos/developers/keys/{id}/toggle', 'Toggle API key active state (POS-prefixed mount)'],
                        'ep-developer-api-keys-destroy-pos' => ['DELETE', '/api/v1/pos/developers/keys/{id}', 'Revoke API key (POS-prefixed mount)'],
                    ],
                ],
                'developer-webhooks' => [
                    'title' => 'Developer Webhooks',
                    'description' => 'Configure outbound webhook subscriptions that receive a signed HTTP POST when selected business events occur (sales, invoices, products, stock, GRNs, customers, purchase orders). Each webhook carries its own HMAC secret that can be rotated independently. DeveloperWebhookApiController is mounted twice — under /api/v1/developers and under /api/v1/pos — with identical behavior on each.',
                    'endpoints' => [
                        'ep-developer-webhooks-index' => ['GET', '/api/v1/developers/webhooks', 'List webhooks'],
                        'ep-developer-webhooks-store' => ['POST', '/api/v1/developers/webhooks', 'Create webhook'],
                        'ep-developer-webhooks-update' => ['PATCH', '/api/v1/developers/webhooks/{id}', 'Update webhook'],
                        'ep-developer-webhooks-regenerate-secret' => ['POST', '/api/v1/developers/webhooks/{id}/regenerate-secret', 'Regenerate webhook secret'],
                        'ep-developer-webhooks-destroy' => ['DELETE', '/api/v1/developers/webhooks/{id}', 'Delete webhook'],
                        'ep-developer-webhooks-index-pos' => ['GET', '/api/v1/pos/developers/webhooks', 'List webhooks (POS-prefixed mount)'],
                        'ep-developer-webhooks-store-pos' => ['POST', '/api/v1/pos/developers/webhooks', 'Create webhook (POS-prefixed mount)'],
                        'ep-developer-webhooks-update-pos' => ['PATCH', '/api/v1/pos/developers/webhooks/{id}', 'Update webhook (POS-prefixed mount)'],
                        'ep-developer-webhooks-regenerate-secret-pos' => ['POST', '/api/v1/pos/developers/webhooks/{id}/regenerate-secret', 'Regenerate webhook secret (POS-prefixed mount)'],
                        'ep-developer-webhooks-destroy-pos' => ['DELETE', '/api/v1/pos/developers/webhooks/{id}', 'Delete webhook (POS-prefixed mount)'],
                    ],
                ],
                'project-manage' => [
                    'title' => 'Project Management',
                    'description' => 'Internal project and task tracking for a business — projects, a kanban-style task board, milestones, task comments, and per-task time logging. All 18 routes are handled by the single ProjectManageApiController (constructor-injected with ProjectService, TaskService, and MilestoneService) and mounted under /api/v1/pos/pm/.... Tasks and milestones are scoped to a business indirectly: the controller loads the record, then aborts with 404 unless its parent project\'s business_id matches the caller\'s resolved business.',
                    'endpoints' => [
                        'ep-project-manage-projects-index' => ['GET', '/api/v1/pos/pm/projects', 'List projects'],
                        'ep-project-manage-projects-store' => ['POST', '/api/v1/pos/pm/projects', 'Create project'],
                        'ep-project-manage-projects-update' => ['PATCH', '/api/v1/pos/pm/projects/{id}', 'Update project'],
                        'ep-project-manage-projects-destroy' => ['DELETE', '/api/v1/pos/pm/projects/{id}', 'Delete project'],
                        'ep-project-manage-board' => ['GET', '/api/v1/pos/pm/projects/{id}/board', 'Get kanban board'],
                        'ep-project-manage-milestones-index' => ['GET', '/api/v1/pos/pm/projects/{id}/milestones', 'List milestones'],
                        'ep-project-manage-milestones-store' => ['POST', '/api/v1/pos/pm/projects/{id}/milestones', 'Create milestone'],
                        'ep-project-manage-milestones-complete' => ['POST', '/api/v1/pos/pm/milestones/{id}/complete', 'Complete milestone'],
                        'ep-project-manage-milestones-destroy' => ['DELETE', '/api/v1/pos/pm/milestones/{id}', 'Delete milestone'],
                        'ep-project-manage-tasks-index' => ['GET', '/api/v1/pos/pm/projects/{id}/tasks', 'List tasks in project'],
                        'ep-project-manage-tasks-store' => ['POST', '/api/v1/pos/pm/projects/{id}/tasks', 'Create task'],
                        'ep-project-manage-tasks-status' => ['PATCH', '/api/v1/pos/pm/tasks/{id}/status', 'Move task to a status column'],
                        'ep-project-manage-tasks-complete' => ['POST', '/api/v1/pos/pm/tasks/{id}/complete', 'Complete task'],
                        'ep-project-manage-tasks-reopen' => ['POST', '/api/v1/pos/pm/tasks/{id}/reopen', 'Reopen task'],
                        'ep-project-manage-tasks-destroy' => ['DELETE', '/api/v1/pos/pm/tasks/{id}', 'Delete task'],
                        'ep-project-manage-tasks-comment' => ['POST', '/api/v1/pos/pm/tasks/{id}/comments', 'Add task comment'],
                        'ep-project-manage-tasks-time' => ['POST', '/api/v1/pos/pm/tasks/{id}/time', 'Log time against task'],
                        'ep-project-manage-my-tasks' => ['GET', '/api/v1/pos/pm/my-tasks', 'List my tasks'],
                    ],
                ],
            ],
        ],

        'platform-modules' => [
            'title' => 'Platform Modules',
            'label' => 'Other modules · 41 endpoints',
            'icon' => 'fa-cubes',
            'description' => 'Smaller platform-level modules: workflow automation, account and business records, purchasing, theming, desktop app release distribution, settings, documentation, standalone services, the core Design Studio module, and HR attendance-device ingestion.',
            'title_si' => 'වේදිකා මොඩියුල',
            'description_si' => 'කුඩා වේදිකා මට්ටමේ මොඩියුල: වැඩ ප්‍රවාහ ස්වයංක්‍රීයකරණය, ගිණුම් සහ ව්‍යාපාර වාර්තා, මිලදී ගැනීම්, තේමා, ඩෙස්ක්ටොප් ඇප් නිකුතු බෙදාහැරීම, සැකසුම්, ලේඛන, ස්වාධීන සේවා, මූලික ඩිසයින් ස්ටූඩියෝ මොඩියුලය සහ HR පැමිණීම් උපාංග දත්ත.',
            'resources' => [
                'automation-editor' => [
                    'title' => 'Automation Editor',
                    'description' => 'Drag-and-drop workflow automation flows (trigger → action canvases) for a business, plus their run history and in-app notifications. All routes live under /api/v1/pos and use the same business-resolution helper as the Pos API.',
                    'endpoints' => [
                        'ep-automation-editor-index' => ['GET', '/api/v1/pos/automations', 'List automation flows'],
                        'ep-automation-editor-store' => ['POST', '/api/v1/pos/automations', 'Create automation flow'],
                        'ep-automation-editor-show' => ['GET', '/api/v1/pos/automations/{id}', 'Get automation flow'],
                        'ep-automation-editor-update' => ['PATCH', '/api/v1/pos/automations/{id}', 'Update automation flow'],
                        'ep-automation-editor-destroy' => ['DELETE', '/api/v1/pos/automations/{id}', 'Delete automation flow'],
                        'ep-automation-editor-runs' => ['GET', '/api/v1/pos/automations/{id}/runs', 'List flow run history'],
                        'ep-automation-editor-trigger' => ['POST', '/api/v1/pos/automations/{id}/trigger', 'Manually trigger a flow'],
                        'ep-automation-editor-notifications' => ['GET', '/api/v1/pos/automation-notifications', 'List automation notifications'],
                        'ep-automation-editor-notifications-read-all' => ['POST', '/api/v1/pos/automation-notifications/read-all', 'Mark all notifications read'],
                    ],
                ],
                'account' => [
                    'title' => 'Account',
                    'description' => 'CRUD for bank/finance accounts (operating, savings, petty cash, payroll, etc.) owned by the authenticated user — the payment-source records referenced by Purchases, Loans, Bills, and Rentals. Scoping here is by user_id, not by the X-Business-Id header convention used elsewhere.',
                    'endpoints' => [
                        'ep-account-index' => ['GET', '/api/v1/accounts', 'List accounts'],
                        'ep-account-store' => ['POST', '/api/v1/accounts', 'Create account'],
                        'ep-account-show' => ['GET', '/api/v1/accounts/{account}', 'Get account'],
                        'ep-account-update' => ['PUT/PATCH', '/api/v1/accounts/{account}', 'Update account'],
                        'ep-account-destroy' => ['DELETE', '/api/v1/accounts/{account}', 'Delete account'],
                    ],
                ],
                'business' => [
                    'title' => 'Business',
                    'description' => 'Registered under /api/v1/businesses as a standard Route::apiResource, but BusinessController implements none of the five resource methods (index, store, show, update, destroy) — only unrelated custom actions like profile, updateBrand, and updateFeatures exist on the class, which are wired to separate web routes, not these API routes.',
                    'endpoints' => [
                        'ep-business-index' => ['GET', '/api/v1/businesses', 'List businesses'],
                        'ep-business-store' => ['POST', '/api/v1/businesses', 'Create business'],
                        'ep-business-show' => ['GET', '/api/v1/businesses/{business}', 'Get business'],
                        'ep-business-update' => ['PUT/PATCH', '/api/v1/businesses/{business}', 'Update business'],
                        'ep-business-destroy' => ['DELETE', '/api/v1/businesses/{business}', 'Delete business'],
                    ],
                ],
                'purchase' => [
                    'title' => 'Purchase',
                    'description' => 'Registered under /api/v1/purchases as an apiResource, but PurchaseController\'s actions are the same code that backs the server-rendered purchase-order screens — they return Blade views and HTTP redirects, not JSON, so this chapter documents real request validation but non-JSON responses.',
                    'endpoints' => [
                        'ep-purchase-index' => ['GET', '/api/v1/purchases', 'List purchases'],
                        'ep-purchase-store' => ['POST', '/api/v1/purchases', 'Create purchase order'],
                        'ep-purchase-show' => ['GET', '/api/v1/purchases/{purchase}', 'Get purchase order'],
                        'ep-purchase-update' => ['PUT/PATCH', '/api/v1/purchases/{purchase}', 'Update purchase order'],
                        'ep-purchase-destroy' => ['DELETE', '/api/v1/purchases/{purchase}', 'Delete purchase order'],
                    ],
                ],
                'theme' => [
                    'title' => 'Theme',
                    'description' => 'A scaffolded-but-unfinished apiResource under /api/v1/themes: there is no Theme Eloquent model and no database table backing it. store, update, and destroy are empty method bodies that do nothing and return an empty response; index/show attempt to render Blade views, most of which don\'t exist in the module.',
                    'endpoints' => [
                        'ep-theme-index' => ['GET', '/api/v1/themes', 'List themes'],
                        'ep-theme-store' => ['POST', '/api/v1/themes', 'Create theme'],
                        'ep-theme-show' => ['GET', '/api/v1/themes/{theme}', 'Get theme'],
                        'ep-theme-update' => ['PUT/PATCH', '/api/v1/themes/{theme}', 'Update theme'],
                        'ep-theme-destroy' => ['DELETE', '/api/v1/themes/{theme}', 'Delete theme'],
                    ],
                ],
                'app-connection' => [
                    'title' => 'App Connections',
                    'description' => 'Desktop app (pos-desktop / Electron) release distribution: publishing a new build\'s download links and checking for the latest stable version. Not part of the Sanctum/business-scoped conventions used elsewhere — auth is a shared API key, or none at all.',
                    'endpoints' => [
                        'ep-app-connection-store' => ['POST', '/api/releases', 'Publish a release'],
                        'ep-app-connection-index' => ['GET', '/api/releases', 'List releases'],
                        'ep-app-connection-latest' => ['GET', '/api/releases/latest', 'Get latest stable release'],
                    ],
                ],
                'settings' => [
                    'title' => 'Settings',
                    'description' => 'Reads and writes individual key/value settings entries for either the authenticated user or their current business, using field definitions loaded from Modules/Settings/database/seeders/settings-fields.json. Despite living under /api/v1/settings, these actions return Blade views and redirects, not JSON — there is no expectsJson() branch anywhere in the controller.',
                    'endpoints' => [
                        'ep-settings-index' => ['GET', '/api/v1/settings', 'Render user settings page'],
                        'ep-settings-store' => ['POST', '/api/v1/settings', 'Set a single setting value'],
                        'ep-settings-destroy' => ['DELETE', '/api/v1/settings', 'Unset a setting value'],
                    ],
                ],
                'documentation' => [
                    'title' => 'Documentation',
                    'description' => 'Read-only knowledge-base articles. When the authenticated user owns a business, results are scoped to that business\'s private + draft docs; otherwise the endpoints fall back to publicly published platform docs. This is a genuine JSON API, but list responses use Laravel\'s default paginator shape rather than the data/meta envelope used elsewhere.',
                    'endpoints' => [
                        'ep-documentation-index' => ['GET', '/api/documentation', 'List documents'],
                        'ep-documentation-show' => ['GET', '/api/documentation/{document}', 'Get document'],
                    ],
                ],
                'service' => [
                    'title' => 'Service',
                    'description' => 'Powers the "Services" POS till: browsing the sellable service catalog and checking out a cart of services into ServiceRequest records, deducting stock for any products assigned to a service item along the way.',
                    'endpoints' => [
                        'ep-service-catalog' => ['GET', '/api/v1/pos/service/pos/catalog', 'Get service POS catalog'],
                        'ep-service-checkout' => ['POST', '/api/v1/pos/service/pos/checkout', 'Checkout services'],
                    ],
                ],
                'design-studio-core' => [
                    'title' => 'Design Studio (core)',
                    'description' => 'A stub endpoint on the top-level Design Studio module. It always returns an empty placeholder payload — it does not query any Design records. This is distinct from Modules\\Pos\\Http\\Controllers\\Api\\PosDesignStudioApiController, the Pos-scoped Design Studio API that actually backs the letterhead/label canvas editor and is documented elsewhere.',
                    'endpoints' => [
                        'ep-design-studio-core-index' => ['GET', '/api/v1/design-studio', 'Design Studio API placeholder'],
                    ],
                ],
                'hr-management-core' => [
                    'title' => 'HR Management (core)',
                    'description' => 'A webhook ingestion endpoint for physical biometric/attendance devices to push punch (clock-in/clock-out) events into the HR attendance system. Confirmed from AttendanceIngestionService: incoming punches are deduplicated, matched to an employee via an active EmployeeBiometricMapping for the device, and folded into daily AttendanceRecords.',
                    'endpoints' => [
                        'ep-hr-management-core-ingest' => ['POST', '/api/v1/hr/attendance/device-punches', 'Ingest attendance device punches'],
                    ],
                ],
            ],
        ],

    ],

];
