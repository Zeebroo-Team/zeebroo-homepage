@extends('admin.layouts.app')

@section('title', 'Blog categories')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    @include('admin.partials.search', ['search' => $search])
    @can('create blog categories')
      <a class="adm-btn ink" href="{{ route('admin.blog.categories.create') }}"><i class="fa-solid fa-plus"></i>New category</a>
    @endcan
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Name</th><th>Slug</th><th>Posts</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($categories as $category)
          <tr>
            <td><b>{{ $category->name }}</b>@if ($category->description)<small>{{ Str::limit($category->description, 80) }}</small>@endif</td>
            <td><code>{{ $category->slug }}</code></td>
            <td>{{ $category->blogs_count }}</td>
            <td>@include('admin.partials.status', ['active' => $category->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $category->name,
              'edit' => auth()->user()->can('edit blog categories') ? route('admin.blog.categories.edit', $category) : null,
              'delete' => auth()->user()->can('delete blog categories') ? route('admin.blog.categories.destroy', $category) : null,
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
