{{-- Search box for list pages. Needs: $search --}}
<form class="adm-filter" method="get">
  <div class="adm-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" name="q" value="{{ $search }}" placeholder="Search" aria-label="Search">
  </div>
  <button type="submit" class="adm-btn line">Search</button>
</form>
