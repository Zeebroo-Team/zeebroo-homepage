<div class="doc-sec">
  <h3 id="opening-feature-management">Opening Feature Management</h3>
  <p>Click the <span class="tab-label">HOME</span> tab → <strong>Tools</strong> group → <span class="ui">Feature Management</span>. A modal opens showing all available features with toggle switches.</p>
  <figure class="screenshot-figure">
    <img src="{{ asset('assets/docs/10-feature-mgmt.png') }}" alt="Feature Management modal" loading="lazy">
    <figcaption class="screenshot-caption">Feature Management modal — toggle each feature on or off. Enabling Restaurant automatically disables Point of Sale, and vice versa.</figcaption>
  </figure>
</div>

<div class="doc-sec">
  <h3 id="enabling-and-disabling-features">Enabling and Disabling Features</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Click a toggle to change its state</strong>
        <p>Blue (on) means the feature is enabled. Grey (off) means it's disabled. The toggle updates instantly in the modal.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Note mutual exclusivity</strong>
        <p>Enabling <strong>Restaurant</strong> automatically disables <strong>Point of Sale</strong>, and vice versa. You cannot run both simultaneously.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>Click Save Changes</strong>
        <p>The app saves your preferences to the server and reloads. Ribbon tabs for disabled features disappear; tabs for newly enabled features appear.</p>
      </div>
    </div>
  </div>

  <div class="callout note">
    <div class="callout-icon"><i class="fa-solid fa-circle-info"></i></div>
    <div class="callout-body">
      <strong>Note</strong>
      Your data is never deleted when you disable a feature. Re-enabling it restores full access to all previously entered records.
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="industry-specific-defaults">Industry-Specific Defaults</h3>
  <p>When you choose <strong>Restaurant</strong> or <strong>Bar</strong> as your industry during registration, the Restaurant feature is automatically enabled and Point of Sale is disabled. You can change this at any time through Feature Management.</p>
</div>
