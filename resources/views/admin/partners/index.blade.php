@extends('admin.layouts.app')

@section('title', 'Partners & clients')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <form class="adm-filter" method="get">
      <div class="adm-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search partners" aria-label="Search partners">
      </div>
      <select name="category" aria-label="Category">
        <option value="">All categories</option>
        @foreach ($categories as $id => $name)
          <option value="{{ $id }}" @selected($categoryId === $id)>{{ $name }}</option>
        @endforeach
      </select>
      <select name="home" aria-label="Home page">
        <option value="">All partners</option>
        <option value="featured" @selected($homeFilter === 'featured')>Featured</option>
        <option value="not-featured" @selected($homeFilter === 'not-featured')>Not featured</option>
      </select>
      <button type="submit" class="adm-btn line">Filter</button>
    </form>
    @can('create partners')
      <a class="adm-btn ink" href="{{ route('admin.partners.create') }}"><i class="fa-solid fa-plus"></i>New partner</a>
    @endcan
    <small>Only partners that are both featured and active scroll in the logo strip on the home page. Click a Home page pill to switch it. Lower order numbers come first.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Partner</th><th>Category</th><th>Order</th><th>Home page</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($partners as $partner)
          <tr>
            <td>
              <div class="adm-post">
                @if ($partner->logo_url)
                  <img class="adm-logo-thumb" src="{{ $partner->logo_url }}" alt="">
                @else
                  <span>{{ $partner->initials }}</span>
                @endif
                <div>
                  <b>{{ $partner->name }}</b>
                  @if ($partner->website_host)<small>{{ $partner->website_host }}</small>@endif
                </div>
              </div>
            </td>
            <td>{{ $partner->category?->name ?? '—' }}</td>
            <td>{{ $partner->sort_order }}</td>
            <td>
              @php($homeLabel = $partner->is_featured ? ($partner->is_active ? 'Featured' : 'Featured · hidden') : 'No')
              @can('edit partners')
                <form method="post" action="{{ route('admin.partners.featured', $partner) }}">
                  @csrf
                  @method('patch')
                  <button type="submit" @class(['adm-pill', 'adm-pill-btn', 'ok' => $partner->is_featured && $partner->is_active]) title="{{ $partner->is_featured ? 'Remove from home page' : 'Show on home page' }}">
                    <i @class(['fa-star', 'fa-solid' => $partner->is_featured, 'fa-regular' => ! $partner->is_featured])></i>{{ $homeLabel }}
                  </button>
                </form>
              @else
                @include('admin.partials.status', ['active' => $partner->is_featured && $partner->is_active, 'label' => $homeLabel])
              @endcan
            </td>
            <td>@include('admin.partials.status', ['active' => $partner->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $partner->name,
              'edit' => auth()->user()->can('edit partners') ? route('admin.partners.edit', $partner) : null,
              'delete' => auth()->user()->can('delete partners') ? route('admin.partners.destroy', $partner) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="6" class="adm-empty">No partners yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $partners->links() }}
</div>
@endsection
