@extends('admin.layouts.app')

@section('title', 'Partner categories')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    @include('admin.partials.search', ['search' => $search])
    @can('create partner categories')
      <a class="adm-btn ink" href="{{ route('admin.partner-categories.create') }}"><i class="fa-solid fa-plus"></i>New category</a>
    @endcan
    <small>Shown in this order as the filter tabs and sections on /partners. Lower numbers come first.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Category</th><th>Order</th><th>Partners</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($categories as $category)
          <tr>
            <td>
              <div class="adm-post">
                <span><i class="fa-solid {{ $category->icon }}"></i></span>
                <div>
                  <b>{{ $category->name }}</b>
                  <small><code>/partners?category={{ $category->slug }}</code></small>
                </div>
              </div>
            </td>
            <td>{{ $category->sort_order }}</td>
            <td>
              @can('view partners')
                <a href="{{ route('admin.partners.index', ['category' => $category->id]) }}">{{ $category->partners_count }}</a>
              @else
                {{ $category->partners_count }}
              @endcan
            </td>
            <td>@include('admin.partials.status', ['active' => $category->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $category->name,
              'edit' => auth()->user()->can('edit partner categories') ? route('admin.partner-categories.edit', $category) : null,
              'delete' => auth()->user()->can('delete partner categories') ? route('admin.partner-categories.destroy', $category) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="5" class="adm-empty">No categories yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $categories->links() }}
</div>
@endsection
