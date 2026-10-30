@extends('admin.layouts.app')

@section('title', 'Docs pages')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <form class="adm-filter" method="get">
      <div class="adm-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search title or address" aria-label="Search docs pages">
      </div>
      <button type="submit" class="adm-btn line">Filter</button>
    </form>
    @can('create docs')
      <a class="adm-btn ink" href="{{ route('admin.docs.pages.create') }}"><i class="fa-solid fa-plus"></i>New page</a>
    @endcan
    <small>The chapters of the user guide at /docs, in sidebar order (by group, then order number). Previous / next links follow this order.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Page</th><th>Group</th><th>Sections</th><th>Order</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($pages as $page)
          <tr>
            <td>
              <div class="adm-post">
                <span><i class="fa-solid {{ $page->icon }}"></i></span>
                <div>
                  <b>{{ $page->number }} · {{ $page->title }}</b>
                  <small><a href="{{ route('docs.show', $page->slug) }}" target="_blank" rel="noopener">/docs/{{ $page->slug }}</a></small>
                </div>
              </div>
            </td>
            <td>{{ $page->group->name }}</td>
            <td>{{ $page->sections_count }}</td>
            <td>{{ $page->sort_order }}</td>
            <td>@include('admin.partials.status', ['active' => $page->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $page->title,
              'edit' => auth()->user()->can('edit docs') ? route('admin.docs.pages.edit', $page) : null,
              'delete' => auth()->user()->can('delete docs') ? route('admin.docs.pages.destroy', $page) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="6" class="adm-empty">No docs pages yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
