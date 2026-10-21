<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Replaces every blog category, tag and post with Zeebroo's starter content.
 * Destructive: run it once on a fresh install (php artisan db:seed --class=BlogSeeder).
 */
class BlogSeeder extends Seeder
{
    /**
     * @var list<array{name: string, slug: string, description: string}>
     */
    public const CATEGORIES = [
        ['name' => 'Product Updates', 'slug' => 'product-updates', 'description' => 'New modules, features and improvements shipping across the Zeebroo platform.'],
        ['name' => 'Retail & POS Tips', 'slug' => 'retail-pos-tips', 'description' => 'Practical advice for faster checkouts, happier customers and a smoother shop floor.'],
        ['name' => 'Inventory & Stock', 'slug' => 'inventory-stock', 'description' => 'Reorder levels, batches, expiry dates and stock counts, done right.'],
        ['name' => 'Finance & Accounting', 'slug' => 'finance-accounting', 'description' => 'Bills, expenses, ledgers and month-end, explained for busy business owners.'],
        ['name' => 'Team & HR', 'slug' => 'team-hr', 'description' => 'Staff, attendance and payroll without the spreadsheets.'],
        ['name' => 'Marketing & Growth', 'slug' => 'marketing-growth', 'description' => 'Campaigns, loyalty and customer relationships that bring people back.'],
        ['name' => 'Guides & Tutorials', 'slug' => 'guides-tutorials', 'description' => 'Step-by-step walkthroughs for setting up and getting the most out of Zeebroo.'],
    ];

    /**
     * @var array<string, string> slug => name
     */
    private const TAGS = [
        'point-of-sale' => 'Point of Sale',
        'desktop-pos' => 'Desktop POS',
        'stock-management' => 'Stock Management',
        'accounting' => 'Accounting',
        'bills-expenses' => 'Bills & Expenses',
        'payroll' => 'Payroll',
        'multibranch' => 'Multibranch',
        'crm' => 'CRM',
        'loyalty' => 'Loyalty',
        'social-campaigns' => 'Social Campaigns',
        'automation' => 'Automation',
        'ai-agent' => 'AI Agent',
        'reports' => 'Reports',
        'small-business' => 'Small Business',
        'retail' => 'Retail',
        'restaurant' => 'Restaurant',
        'pharmacy' => 'Pharmacy',
        'wholesale' => 'Wholesale',
    ];

    public function run(): void
    {
        $this->clean();

        /** @var array{categories: array<string, array{name: string, description: string}>, posts: array<string, array{title: string, meta_title: string, meta_description: string, meta_keywords: string, body: string}>} $sinhala */
        $sinhala = require database_path('seeders/data/blogs.si.php');

        $categories = collect(self::CATEGORIES)
            ->mapWithKeys(fn (array $c) => [$c['slug'] => BlogCategory::create($c + [
                'name_si' => $sinhala['categories'][$c['slug']]['name'] ?? null,
                'description_si' => $sinhala['categories'][$c['slug']]['description'] ?? null,
                'is_active' => true,
            ])]);

        $tags = collect(self::TAGS)
            ->map(fn (string $name, string $slug) => BlogTag::create(['name' => $name, 'slug' => $slug, 'is_active' => true]));

        foreach (self::posts() as $post) {
            $si = $sinhala['posts'][$post['slug']] ?? [];

            $blog = Blog::create([
                'title' => $post['title'],
                'title_si' => $si['title'] ?? null,
                'slug' => $post['slug'],
                'meta_title' => $post['meta_title'],
                'meta_title_si' => $si['meta_title'] ?? null,
                'meta_description' => $post['meta_description'],
                'meta_description_si' => $si['meta_description'] ?? null,
                'meta_keywords' => $post['meta_keywords'],
                'meta_keywords_si' => $si['meta_keywords'] ?? null,
                'category_id' => $categories[$post['category']]->id,
                'author_name' => 'Zeebroo Team',
                'published_at' => now()->subDays($post['days_ago'])->setTime(9, 0),
                'description' => trim($post['body']),
                'description_si' => isset($si['body']) ? trim($si['body']) : null,
                'image_path' => $this->copyCover($post['image'], $post['slug']),
                'is_active' => true,
            ]);

            $blog->tags()->attach($tags->only($post['tags'])->pluck('id'));
        }
    }

    /**
     * Remove every existing post, tag, category and uploaded blog image.
     */
    private function clean(): void
    {
        DB::table('blog_blog_tag')->delete();
        Blog::query()->delete();
        BlogTag::query()->delete();
        BlogCategory::query()->delete();

        Storage::disk('public')->deleteDirectory('blogs');
    }

    /**
     * Copy a mascot illustration from public/assets/features to the public disk, like an admin upload.
     */
    private function copyCover(?string $file, string $slug): ?string
    {
        $source = $file ? public_path('assets/features/'.$file) : null;

        if (! $source || ! is_file($source)) {
            return null;
        }

        $path = 'blogs/'.$slug.'.'.pathinfo($file, PATHINFO_EXTENSION);
        Storage::disk('public')->put($path, file_get_contents($source));

        return $path;
    }

    /**
     * @return list<array{title: string, slug: string, meta_title: string, meta_description: string, meta_keywords: string, category: string, tags: list<string>, image: ?string, days_ago: int, body: string}>
     */
    public static function posts(): array
    {
        return [
            [
                'title' => 'Introducing the Zeebroo AI Agent: ask your business anything',
                'slug' => 'introducing-the-zeebroo-ai-agent',
                'meta_title' => 'Introducing the Zeebroo AI Agent',
                'meta_description' => 'Ask plain-language questions about sales, stock, bills and staff, and get answers from your live Zeebroo data in seconds.',
                'meta_keywords' => 'zeebroo ai agent, ai for small business, pos analytics, business insights',
                'category' => 'product-updates',
                'tags' => ['ai-agent', 'reports', 'small-business'],
                'image' => null,
                'days_ago' => 3,
                'body' => <<<'HTML'
<p>Every business owner has questions that a report almost answers. <em>Which products sold best last weekend? Which supplier bills are due this week? Who worked the most overtime this month?</em> Until now, getting those answers meant opening three screens, exporting a spreadsheet and doing the maths yourself.</p>
<p>Today we're introducing the <strong>Zeebroo AI Agent</strong>, a new module that lets you ask your business anything in plain language.</p>
<h2>One question, every module</h2>
<p>Because every Zeebroo module shares the same live data, the AI Agent can look across sales, stock, bills, accounts and HR in a single answer. Ask a question the way you'd ask a colleague:</p>
<ul>
  <li>"What were my top 10 products by profit last month?"</li>
  <li>"Which items will run out before next Friday at the current sales rate?"</li>
  <li>"How much did we spend on utilities this quarter compared with last?"</li>
  <li>"Which branch had the highest average basket size yesterday?"</li>
</ul>
<p>The agent replies with the numbers, a short explanation and a link to the screen where you can dig deeper.</p>
<h2>Built on your data, not guesses</h2>
<p>The AI Agent only answers from the records in your Zeebroo account. If the data isn't there, it tells you so instead of making something up. It also respects user roles: a cashier asking about payroll gets the same "no access" they'd see anywhere else in the platform.</p>
<blockquote>The goal isn't to replace your reports. It's to get you to the right report, with the right filter, in one sentence.</blockquote>
<h2>Getting started</h2>
<p>Turn on the AI Agent from <strong>Settings → Modules</strong>. It appears as a chat panel on every screen, so you can ask a question without losing your place. We recommend starting with the questions you already ask every Monday morning. You'll be surprised how much time comes back.</p>
HTML,
            ],
            [
                'title' => '7 ways to speed up checkout at your point of sale',
                'slug' => '7-ways-to-speed-up-checkout',
                'meta_title' => '7 Ways to Speed Up Checkout at Your POS',
                'meta_description' => 'Shorter queues mean more sales. Seven practical changes to make your Zeebroo point of sale faster for cashiers and customers.',
                'meta_keywords' => 'faster checkout, pos tips, reduce queue time, retail checkout',
                'category' => 'retail-pos-tips',
                'tags' => ['point-of-sale', 'desktop-pos', 'retail'],
                'image' => 'pos.jpeg',
                'days_ago' => 9,
                'body' => <<<'HTML'
<p>A long queue costs more than a customer's patience. People abandon baskets, skip the impulse buys at the counter and remember the wait the next time they choose where to shop. The good news: most checkout delays come from a handful of fixable habits.</p>
<h2>1. Put your best sellers on quick keys</h2>
<p>Items without barcodes, such as bakery goods, loose produce or services, shouldn't need a search. Pin your 20 most-sold items to the quick keys on the Zeebroo POS screen so they're always one tap away.</p>
<h2>2. Scan, don't type</h2>
<p>Make sure every packaged product has its barcode saved in Product Management. A USB or Bluetooth scanner works with the POS out of the box, and every scan saves a few seconds and a possible typo.</p>
<h2>3. Use the desktop POS on your main counters</h2>
<p>The Zeebroo desktop app is built for high-volume tills. It stays responsive during rush hours and connects directly to your receipt printer and cash drawer.</p>
<h2>4. Set up payment methods in advance</h2>
<p>Card, cash, mobile wallet, split payments: configure them once so cashiers simply pick one. No more asking a manager how to record a mixed payment.</p>
<h2>5. Find customers by phone number</h2>
<p>With CRM switched on, typing a phone number pulls up the customer, their loyalty points and their last purchase. It's faster than asking for a name and spelling it.</p>
<h2>6. Keep discounts rule-based</h2>
<p>Manual discounts slow the line and invite mistakes. Create promotions in advance so the POS applies them automatically when the right items hit the basket.</p>
<h2>7. Review your slowest hour every week</h2>
<p>Open the sales report, filter by hour and look at transactions per cashier. If one hour is always slow, it's usually a staffing or training issue, and now you have the numbers to fix it.</p>
<p>Small changes add up. Shave ten seconds off each sale and a busy shop gets back hours every week.</p>
HTML,
            ],
            [
                'title' => 'Stop running out: how to set reorder levels that actually work',
                'slug' => 'how-to-set-reorder-levels',
                'meta_title' => 'How to Set Reorder Levels That Actually Work',
                'meta_description' => 'Stockouts lose sales and overstock ties up cash. A simple method for setting reorder levels in Zeebroo Stock Management.',
                'meta_keywords' => 'reorder level, reorder point, stock management, inventory control, avoid stockouts',
                'category' => 'inventory-stock',
                'tags' => ['stock-management', 'retail', 'wholesale'],
                'image' => 'product_management.png',
                'days_ago' => 16,
                'body' => <<<'HTML'
<p>Every empty shelf is a sale you didn't make, and every box gathering dust in the back room is cash you can't spend. Reorder levels are how you find the balance, but only if they're set from real numbers, not gut feeling.</p>
<h2>The simple formula</h2>
<p>A reorder level is the stock quantity at which you should place a new order. The classic way to calculate it:</p>
<p><strong>Reorder level = (average daily sales × supplier lead time in days) + safety stock</strong></p>
<p>For example, if you sell 12 units a day, your supplier takes 5 days to deliver and you keep 3 days of safety stock, your reorder level is (12 × 5) + (12 × 3) = <strong>96 units</strong>.</p>
<h2>Where to find the numbers in Zeebroo</h2>
<ol>
  <li><strong>Average daily sales:</strong> open the product in Stock Management and check its sales history for the last 30 or 90 days.</li>
  <li><strong>Lead time:</strong> look at your past purchase orders for that supplier. How many days between ordering and receiving?</li>
  <li><strong>Safety stock:</strong> start with 2 to 3 days of sales for steady items and more for products with unpredictable demand.</li>
</ol>
<h2>Let the system watch for you</h2>
<p>Once a reorder level is saved on a product, Zeebroo flags it the moment stock drops below that line. Pair it with the Automation Editor to notify your purchasing team, or to draft a purchase order automatically.</p>
<h2>Review seasonally</h2>
<p>Demand changes. A reorder level that worked in January can leave you short in December. Set a reminder to review your top 50 products every quarter, and adjust before the busy season rather than during it.</p>
<blockquote>Good reorder levels don't eliminate judgement. They free you to use it where it matters.</blockquote>
HTML,
            ],
            [
                'title' => 'Batch and expiry tracking for pharmacies: a practical guide',
                'slug' => 'batch-and-expiry-tracking-for-pharmacies',
                'meta_title' => 'Batch and Expiry Tracking for Pharmacies',
                'meta_description' => 'Track batches and expiry dates, sell first-expiring stock first, and cut write-offs with Zeebroo Stock Management for pharmacies.',
                'meta_keywords' => 'pharmacy inventory, batch tracking, expiry date tracking, fefo, pharmacy pos',
                'category' => 'inventory-stock',
                'tags' => ['pharmacy', 'stock-management'],
                'image' => null,
                'days_ago' => 23,
                'body' => <<<'HTML'
<p>In a pharmacy, knowing <em>how many</em> boxes you have isn't enough. You need to know which batch they came from and when each one expires. Get it wrong and you're either writing off expired stock or, worse, handing it to a patient.</p>
<h2>Record the batch when stock arrives</h2>
<p>When you receive a delivery in Zeebroo, enter the batch number and expiry date for each line. It takes seconds at the receiving desk and saves hours of shelf checks later.</p>
<h2>Sell first-expiring, first out</h2>
<p>With batches recorded, the POS can pick the batch that expires soonest whenever that product is sold. This is known as <strong>FEFO</strong> (first expired, first out), and it's the single most effective way to reduce write-offs.</p>
<h2>Check what's expiring every week</h2>
<p>Run the expiry report every Monday and filter for the next 60 days. For anything on the list you can:</p>
<ul>
  <li>Move it to the front of the shelf</li>
  <li>Return it to the supplier, if your agreement allows</li>
  <li>Transfer it to a busier branch with Multibranch</li>
  <li>Run a short promotion for over-the-counter items</li>
</ul>
<h2>Recalls in minutes, not days</h2>
<p>When a manufacturer recalls a batch, search for the batch number to see exactly how much you hold, at which branch, and which sales included it. What used to take a day of phone calls becomes a two-minute search.</p>
<p>Batch tracking is a habit as much as a feature. Make it part of receiving and the rest of the system takes care of itself.</p>
HTML,
            ],
            [
                'title' => 'Month-end close in a day: reconciling sales, bills and the ledger',
                'slug' => 'month-end-close-in-a-day',
                'meta_title' => 'Month-End Close in a Day with Zeebroo',
                'meta_description' => 'A step-by-step month-end checklist for small businesses: reconcile sales, bills, expenses and accounts in one day with Zeebroo Accounting.',
                'meta_keywords' => 'month end close, small business accounting, reconciliation checklist, bookkeeping',
                'category' => 'finance-accounting',
                'tags' => ['accounting', 'bills-expenses', 'reports'],
                'image' => 'accounting.jpeg',
                'days_ago' => 31,
                'body' => <<<'HTML'
<p>For many small businesses, month-end means a week of chasing receipts, matching bank lines and wondering why the numbers don't agree. It doesn't have to. When sales, bills and the ledger live in one system, closing the month becomes a checklist instead of a project.</p>
<h2>Why it's faster in Zeebroo</h2>
<p>Every sale at the POS, every supplier bill and every expense posts to the ledger as it happens. There's no export, no import and no second copy of the truth. Month-end becomes about <strong>checking</strong>, not typing.</p>
<h2>The one-day checklist</h2>
<ol>
  <li><strong>Close the tills.</strong> Make sure every register's last shift of the month is closed and cash differences are explained.</li>
  <li><strong>Reconcile your bank and card accounts.</strong> Compare Account Management balances with your bank statements, and record fees or interest the bank added.</li>
  <li><strong>Clear outstanding bills.</strong> In Bill Management, check that every supplier bill for the month is entered and that payments are matched.</li>
  <li><strong>Record recurring expenses.</strong> Rent, utilities and subscriptions can be set as recurring so they're never forgotten.</li>
  <li><strong>Review loans and repayments.</strong> Confirm instalments were recorded against the right loan.</li>
  <li><strong>Count high-value stock.</strong> A partial count of your top items keeps the stock value on the balance sheet honest.</li>
  <li><strong>Run the reports.</strong> Profit and loss, balance sheet and trial balance, then lock the period.</li>
</ol>
<h2>Share with your accountant</h2>
<p>Give your accountant their own login with an accounting role. They see the ledgers and reports they need, without access to payroll or settings, and you stop emailing spreadsheets back and forth.</p>
<blockquote>The fastest month-end is the one where the books were right all month.</blockquote>
HTML,
            ],
            [
                'title' => 'Running payroll and attendance without spreadsheets',
                'slug' => 'payroll-and-attendance-without-spreadsheets',
                'meta_title' => 'Payroll and Attendance Without Spreadsheets',
                'meta_description' => 'Move staff records, attendance and payroll out of spreadsheets and into Zeebroo Human Resources, with fewer errors and on-time pay.',
                'meta_keywords' => 'small business payroll, staff attendance, hr software, payroll without spreadsheets',
                'category' => 'team-hr',
                'tags' => ['payroll', 'small-business'],
                'image' => 'HR management.jpeg',
                'days_ago' => 38,
                'body' => <<<'HTML'
<p>Spreadsheets are where payroll mistakes are born. A formula gets copied wrong, a late shift goes unrecorded, an allowance is forgotten, and someone's pay is off. Moving HR into the same system that runs your shop removes most of those mistakes at the source.</p>
<h2>Start with clean staff records</h2>
<p>Add each employee to Zeebroo Human Resources with their role, branch, salary or hourly rate, and allowances. It's a one-time job that pays off every single pay day.</p>
<h2>Let attendance record itself</h2>
<p>Staff clock in and out from the POS or the web app. Late arrivals, early departures and overtime are calculated for you, with no more reading handwritten timesheets at the end of the month.</p>
<h2>Leave that's tracked, not remembered</h2>
<p>Leave requests are submitted and approved in the system, and balances update automatically. When someone asks "how many days do I have left?", the answer is a click away.</p>
<h2>Payroll in a few steps</h2>
<ol>
  <li>Review the attendance summary for the period.</li>
  <li>Add one-off bonuses or deductions.</li>
  <li>Generate payslips for everyone in one go.</li>
  <li>Approve, and the salary expense posts to your accounts automatically.</li>
</ol>
<h2>The right access for the right people</h2>
<p>Salary information is sensitive. With role-based permissions, only the people you choose can see or run payroll, while managers can still approve leave and view attendance for their own team.</p>
<p>Your team will notice the difference too: accurate pay, on time, with a clear payslip every month.</p>
HTML,
            ],
            [
                'title' => 'Promotions tied to stock: social campaigns that clear slow movers',
                'slug' => 'social-campaigns-that-clear-slow-movers',
                'meta_title' => 'Social Campaigns That Clear Slow-Moving Stock',
                'meta_description' => 'Use Zeebroo Social Campaigns to promote what you actually have in stock, clear slow movers and measure every sale a post brings in.',
                'meta_keywords' => 'social media campaign, retail promotion, slow moving stock, marketing for small business',
                'category' => 'marketing-growth',
                'tags' => ['social-campaigns', 'stock-management', 'crm'],
                'image' => 'Marketer’s Campaign.png',
                'days_ago' => 45,
                'body' => <<<'HTML'
<p>Most shops promote whatever looks good on Instagram. Smart shops promote what they <em>need</em> to sell. When your marketing knows what's sitting in the stockroom, every campaign can do double duty: bring in customers and free up cash.</p>
<h2>Find your slow movers</h2>
<p>Open the stock report and sort by days since last sale. Anything with healthy stock and slow sales is a campaign candidate. These are products customers would buy if they only knew about them.</p>
<h2>Build the campaign from the product</h2>
<p>In Zeebroo Social Campaigns, start from the product itself. The campaign pulls in the name, price and image, so there's no retyping and no risk of advertising the wrong price.</p>
<h2>Promotions that stop when stock runs out</h2>
<p>Because campaigns are tied to stock, a promotion can end automatically when the quantity you set aside is sold. No more apologising to customers who arrive for a deal on an item that sold out yesterday.</p>
<h2>Target the right customers</h2>
<p>With CRM, you can send the offer to customers who bought something similar before. A customer who buys printer paper every month is far more likely to want the ink on promotion than a random follower.</p>
<h2>Measure what matters</h2>
<p>Each campaign tracks the sales it produces at the POS, not just likes and clicks. After a week you'll know exactly how many units moved, what revenue came in, and whether the discount was worth it.</p>
<blockquote>The best campaign is the one that pays for itself before the stock goes out of season.</blockquote>
HTML,
            ],
            [
                'title' => 'Turn first-time buyers into regulars with CRM and loyalty',
                'slug' => 'turn-first-time-buyers-into-regulars',
                'meta_title' => 'Turn First-Time Buyers into Regulars',
                'meta_description' => 'Simple CRM and loyalty habits that bring customers back, using customer profiles, purchase history and points in Zeebroo.',
                'meta_keywords' => 'customer loyalty program, crm for retail, repeat customers, customer retention',
                'category' => 'marketing-growth',
                'tags' => ['crm', 'loyalty', 'retail'],
                'image' => 'CRM.jpeg',
                'days_ago' => 52,
                'body' => <<<'HTML'
<p>Winning a new customer can cost five times more than keeping an existing one. Yet most small businesses know almost nothing about the people who buy from them. A simple CRM habit at the counter changes that.</p>
<h2>Capture the customer at checkout</h2>
<p>Ask for a phone number at the POS. It takes three seconds, and from then on every purchase is linked to a customer profile in Zeebroo CRM: what they buy, how often and how much they spend.</p>
<h2>Reward the behaviour you want</h2>
<p>A loyalty programme doesn't have to be complicated. Start with one rule, such as points for every purchase redeemable on the next visit, and let the POS handle the maths. Customers see their balance on the receipt, which is a gentle reason to come back.</p>
<h2>Know your best customers</h2>
<p>Sort customers by total spend over the last 90 days. Your top 10% probably bring in a third or more of your revenue. Treat them like it: early access to new stock, a birthday offer, or simply a thank-you.</p>
<h2>Win back the quiet ones</h2>
<p>Filter for customers who used to buy regularly but haven't visited in 60 days. A personal message with a small offer often brings back customers you'd otherwise lose without noticing.</p>
<h2>Follow up on leads</h2>
<p>For businesses that quote before they sell, such as wholesalers, service companies and event venues, CRM tracks leads from first enquiry to signed order, so nobody falls through the cracks.</p>
<p>Loyalty isn't a programme. It's the feeling a customer gets when you remember them. CRM just makes remembering easy.</p>
HTML,
            ],
            [
                'title' => 'Opening your second branch: a checklist for multibranch businesses',
                'slug' => 'opening-your-second-branch-checklist',
                'meta_title' => 'Opening a Second Branch: A Multibranch Checklist',
                'meta_description' => 'Planning a new location? A practical checklist for stock, staff, pricing and reporting when you run multiple branches on Zeebroo.',
                'meta_keywords' => 'multi store pos, opening a new branch, multibranch inventory, retail expansion',
                'category' => 'guides-tutorials',
                'tags' => ['multibranch', 'stock-management', 'accounting'],
                'image' => null,
                'days_ago' => 60,
                'body' => <<<'HTML'
<p>Opening a second location is a milestone, and the moment your systems either scale with you or start falling apart. With Zeebroo Multibranch, every location lives in one account, but a little planning makes launch day far smoother.</p>
<h2>Before you open</h2>
<ul>
  <li><strong>Create the branch</strong> in Settings, with its own address, receipt header and tax details.</li>
  <li><strong>Decide on pricing.</strong> Will both branches share one price list, or does the new location need its own? Set this before the first sale.</li>
  <li><strong>Assign registers.</strong> Each POS terminal belongs to one branch, so sales land in the right place.</li>
  <li><strong>Set branch permissions.</strong> A branch manager should see their own branch. You see everything.</li>
</ul>
<h2>Stocking the new shelves</h2>
<p>Rather than placing a brand-new supplier order for everything, use <strong>stock transfers</strong> to move part of your existing stock from the main branch. Every transfer is tracked, so both branches' stock levels stay accurate, and nothing "goes missing" in the van.</p>
<h2>Staff and attendance</h2>
<p>Add new staff to Human Resources under the new branch. Existing staff who split their week between locations can clock in at either one, and their hours still add up to one payslip.</p>
<h2>Reporting that compares like for like</h2>
<p>From day one, run sales and profit reports side by side for each branch. In the first month, watch three numbers closely: average basket size, top-selling products and stock turnover. They tell you quickly whether the new location's customers behave like your existing ones.</p>
<h2>One set of books</h2>
<p>Each branch can have its own accounts and cash balances, while the accounting module consolidates everything into one profit and loss. You see the whole business, and each branch, without merging spreadsheets.</p>
<blockquote>The second branch is the hardest. Get the setup right and the third is a copy-and-paste.</blockquote>
HTML,
            ],
            [
                'title' => 'Setting up Zeebroo for your restaurant: tables, kitchen and menu',
                'slug' => 'setting-up-zeebroo-for-your-restaurant',
                'meta_title' => 'Setting Up Zeebroo for Your Restaurant',
                'meta_description' => 'A step-by-step guide to configuring tables, menus, kitchen orders and ingredient stock in the Zeebroo Restaurant module.',
                'meta_keywords' => 'restaurant pos, restaurant management software, kitchen order system, table management',
                'category' => 'guides-tutorials',
                'tags' => ['restaurant', 'point-of-sale', 'stock-management'],
                'image' => 'returnt management.jpeg',
                'days_ago' => 68,
                'body' => <<<'HTML'
<p>A restaurant runs at a different pace from a shop. Orders arrive in pieces, tables stay open for an hour and the kitchen needs to know what to cook <em>now</em>. The Zeebroo Restaurant module is built for exactly that flow. Here's how to set it up.</p>
<h2>1. Draw your floor plan</h2>
<p>Add your dining areas, such as indoor, terrace or bar, and the tables in each. Servers see a live map showing which tables are free, seated or waiting for the bill.</p>
<h2>2. Build your menu</h2>
<p>Create menu items with categories, prices and modifiers ("no onions", "extra cheese", "well done"). Modifiers can carry their own price, so extras are never forgotten on the bill.</p>
<h2>3. Send orders to the kitchen</h2>
<p>When a server places an order, it goes straight to the kitchen display or printer, grouped by station. Drinks go to the bar, mains to the grill. The kitchen marks items ready, and servers know when to pick them up.</p>
<h2>4. Link dishes to ingredients</h2>
<p>Add a simple recipe to each dish: 150 g of chicken, 1 bun, 20 g of sauce. Every sale then deducts ingredients from stock automatically, so you see food cost per dish and know when to reorder before the dinner rush.</p>
<h2>5. Make the bill painless</h2>
<p>Split bills by item or by guest, add service charges and take payment at the table or the counter. Each closed table posts straight to your sales and accounts.</p>
<h2>6. Read the night's numbers</h2>
<p>At closing, review sales by hour, best-selling dishes and table turnover. Over a few weeks, these numbers tell you when to add staff, which dishes to promote and which to drop.</p>
<p>Start simple with tables and menu, then add recipes and kitchen stations as your team gets comfortable. The system grows with your service.</p>
HTML,
            ],
            [
                'title' => 'Automate the busywork: 5 workflows every shop should build',
                'slug' => 'automate-the-busywork-5-workflows',
                'meta_title' => '5 Automation Workflows Every Shop Should Build',
                'meta_description' => 'Low-stock alerts, overdue bill reminders, daily summaries and more: five easy workflows to build in the Zeebroo Automation Editor.',
                'meta_keywords' => 'business automation, workflow automation, small business automation, zeebroo automation editor',
                'category' => 'product-updates',
                'tags' => ['automation', 'small-business', 'stock-management'],
                'image' => 'Automation_flow.png',
                'days_ago' => 75,
                'body' => <<<'HTML'
<p>Some tasks don't need a person. They just need to happen on time, every time. The Zeebroo Automation Editor lets you build workflows from simple building blocks: a <strong>trigger</strong> (when something happens), optional <strong>conditions</strong>, and <strong>actions</strong> (what to do). No code required.</p>
<p>Here are five workflows we recommend every shop builds in its first week.</p>
<h2>1. Low-stock alert</h2>
<p><strong>When</strong> a product drops below its reorder level, <strong>send</strong> a notification to the purchasing manager with the product, current quantity and usual supplier.</p>
<h2>2. Overdue bill reminder</h2>
<p><strong>When</strong> a supplier bill is three days from its due date and still unpaid, <strong>email</strong> the accounts team. Late fees are an expensive way to learn about a due date.</p>
<h2>3. Daily sales summary</h2>
<p><strong>Every day at closing time</strong>, <strong>send</strong> the owner a summary: total sales, number of transactions, top products and cash difference per register. Know how the day went without logging in.</p>
<h2>4. Thank-you message for big orders</h2>
<p><strong>When</strong> a sale exceeds a value you choose and the customer is in CRM, <strong>send</strong> a thank-you message. It's a small touch that customers remember.</p>
<h2>5. Large discount approval</h2>
<p><strong>When</strong> a cashier applies a discount above a set percentage, <strong>notify</strong> a manager. It's not about mistrust, just a simple control that protects your margins.</p>
<h2>Start small, then grow</h2>
<p>Begin with one workflow, watch it run for a week, then add the next. Each workflow shows a history of every time it ran, so you can see exactly what happened and when.</p>
<blockquote>Automation doesn't replace your team. It gives them back the hours they spent remembering things.</blockquote>
HTML,
            ],
        ];
    }
}
