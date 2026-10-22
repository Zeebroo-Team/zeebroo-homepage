<figure class="screenshot-figure">
  <img src="{{ asset('assets/docs/04-inventory.png') }}" alt="Inventory & Products tab" loading="lazy">
  <figcaption class="screenshot-caption">Inventory tab — product catalog with stock levels, categories, and management tools.</figcaption>
</figure>

<div class="doc-sec">
  <h3 id="adding-a-product">Adding a Product</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Open Inventory</strong>
        <p>Click the <span class="tab-label">INVENTORY</span> tab, then click <span class="ui">New Product</span> in the Catalog ribbon group.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Fill in the Overview tab</strong>
        <p>Enter the <span class="field-label">Product name</span>, <span class="field-label">Category</span>, <span class="field-label">Brand</span>, <span class="field-label">SKU</span>, and <span class="field-label">Barcode</span>. Mark it active to make it visible in the POS.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>Set pricing</strong>
        <p>Go to the <strong>Pricing</strong> tab. Enter the <span class="field-label">Cost price</span> and <span class="field-label">Selling price</span>. You can optionally add tiered selling units (e.g. sell individually and by the dozen at different prices).</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">4</div>
      <div class="step-body">
        <strong>Set initial stock</strong>
        <p>Go to the <strong>Stock</strong> tab. Enter the <span class="field-label">Opening stock quantity</span> and <span class="field-label">Low stock alert level</span>. The app will warn you when stock falls below this threshold.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">5</div>
      <div class="step-body">
        <strong>Add images</strong>
        <p>Go to the <strong>Images</strong> tab. Click <span class="ui">Choose Image</span> to open the image picker — you can upload from your computer, choose from the File Manager, or generate an AI image.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">6</div>
      <div class="step-body">
        <strong>Add variants (optional)</strong>
        <p>Go to the <strong>Variants</strong> tab to create size/colour/style variations of the same product, each with its own SKU and price.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">7</div>
      <div class="step-body">
        <strong>Save</strong>
        <p>Click <span class="ui">Save Product</span>. The product immediately appears in the POS grid.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="categories-brands">Categories &amp; Brands</h3>
  <p>Organise your catalog with categories and brands. In the Inventory ribbon's <strong>Catalog</strong> group:</p>
  <ul>
    <li>Click <span class="ui">Categories</span> to add, rename, or reorder product categories</li>
    <li>Click <span class="ui">Brands</span> to manage your product brands — useful for filtering in both POS and inventory views</li>
    <li>Click <span class="ui">Discounts</span> to create reusable discount rules that can be applied at checkout</li>
  </ul>
</div>

<div class="doc-sec">
  <h3 id="stock-management">Stock Management</h3>
  <p>Track your inventory levels and make adjustments from the <strong>Stock</strong> ribbon group.</p>
  <table class="data-table">
    <tr><th>Action</th><th>When to use</th></tr>
    <tr><td>Stock Audit</td><td>Count physical stock and correct discrepancies. Creates a permanent audit record.</td></tr>
    <tr><td>Stock Adjustment</td><td>Add or remove stock manually — for wastage, loss, or corrections.</td></tr>
    <tr><td>Stock Transfer</td><td>Move stock between branches of the same business.</td></tr>
  </table>
  <div class="callout tip">
    <div class="callout-icon"><i class="fa-solid fa-lightbulb"></i></div>
    <div class="callout-body">
      <strong>Tip</strong>
      Every sale automatically deducts from stock. Every purchase order receipt automatically adds to stock. Manual adjustments create an audit trail with timestamps and user attribution.
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="suppliers">Suppliers</h3>
  <p>Maintain a supplier directory in the <strong>Suppliers</strong> ribbon group. For each supplier, store their name, contact details, address, and default payment terms. Suppliers are then linked to purchase orders.</p>
</div>

<div class="doc-sec">
  <h3 id="purchase-orders">Purchase Orders</h3>
  <p>Manage your purchasing workflow from <span class="ui">Inventory → Purchasing → Purchase Orders</span>.</p>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Create a Draft PO</strong>
        <p>Click <span class="ui">New PO</span>. Select a supplier, set the order date and expected delivery date, then add line items — each with product, quantity, and unit cost.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Place the order</strong>
        <p>Once the PO is ready, click <span class="ui">Place Order</span>. The status changes to <strong>Ordered</strong>. The PO is now locked from further editing.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>Receive goods (GRN)</strong>
        <p>When goods arrive, open the PO and click <span class="ui">Receive Goods</span>. Enter the quantities actually received. A Goods Receipt Note (GRN) is created and stock levels are updated immediately.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="barcode-printing">Barcode Printing</h3>
  <p>Select one or more products in the inventory list, then click <span class="ui">Print Barcodes</span> in the <strong>Print</strong> ribbon group. Choose your label sheet size, set the quantity per product, and print directly to any connected label printer.</p>
</div>
