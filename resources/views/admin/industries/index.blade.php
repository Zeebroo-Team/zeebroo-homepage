@extends('admin.layouts.app')

@section('title', 'Industries')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <form class="adm-filter" method="get">
      <div class="adm-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search industries" aria-label="Search industries">
      </div>
      <button type="submit" class="adm-btn line">Filter</button>
    </form>
    @can('create industries')
      <a class="adm-btn ink" href="{{ route('admin.industries.create') }}"><i class="fa-solid fa-plus"></i>New industry</a>
    @endcan
    <small>Shown in this order in the Industries menu, on /industries and on the home page. Lower numbers come first.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Industry</th><th>Order</th><th>Modules</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($industries as $industry)
          <tr>
            <td>
              <div class="adm-post">
                <span><i class="fa-solid {{ $industry->icon }}"></i></span>
                <div>
                  <b>{{ $industry->title }}@if ($industry->badge) <span class="adm-pill">{{ $industry->badge }}</span>@endif</b>
                  <small><code>/industries/{{ $industry->slug }}</code></small>
                </div>
              </div>
            </td>
            <td>{{ $industry->sort_order }}</td>
            <td>{{ $industry->modules_count ?: '—' }}</td>
            <td>@include('admin.partials.status', ['active' => $industry->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $industry->title,
              'edit' => auth()->user()->can('edit industries') ? route('admin.industries.edit', $industry) : null,
              'delete' => auth()->user()->can('delete industries') ? route('admin.industries.destroy', $industry) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="5" class="adm-empty">No industries yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $industries->links() }}
</div>
@endsection
