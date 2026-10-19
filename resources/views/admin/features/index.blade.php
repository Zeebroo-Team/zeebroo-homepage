@extends('admin.layouts.app')

@section('title', 'Features')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <form class="adm-filter" method="get">
      <div class="adm-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search features" aria-label="Search features">
      </div>
      <select name="group" aria-label="Group">
        <option value="">All groups</option>
        @foreach (\App\Models\Feature::GROUPS as $key => $label)
          <option value="{{ $key }}" @selected($group === $key)>{{ $label }}</option>
        @endforeach
      </select>
      <button type="submit" class="adm-btn line">Filter</button>
    </form>
    @can('create features')
      <a class="adm-btn ink" href="{{ route('admin.features.create') }}"><i class="fa-solid fa-plus"></i>New feature</a>
    @endcan
    <small>Shown in this order in the Modules menu, on /features and on the home page. Lower numbers come first.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Feature</th><th>Group</th><th>Order</th><th>Screenshots</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($features as $feature)
          <tr>
            <td>
              <div class="adm-post">
                @if ($feature->spot_url)<img src="{{ $feature->spot_url }}" alt="">@else<span><i class="fa-solid {{ $feature->icon }}"></i></span>@endif
                <div>
                  <b>{{ $feature->title }}@if ($feature->badge) <span class="adm-pill">{{ $feature->badge }}</span>@endif</b>
                  <small><code>/features/{{ $feature->slug }}</code></small>
                </div>
              </div>
            </td>
            <td>{{ \App\Models\Feature::GROUPS[$feature->group] ?? $feature->group }}</td>
            <td>{{ $feature->sort_order }}</td>
            <td>{{ $feature->screenshots_count ?: '—' }}</td>
            <td>@include('admin.partials.status', ['active' => $feature->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $feature->title,
              'edit' => auth()->user()->can('edit features') ? route('admin.features.edit', $feature) : null,
              'delete' => auth()->user()->can('delete features') ? route('admin.features.destroy', $feature) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="6" class="adm-empty">No features yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $features->links() }}
</div>
@endsection
