@extends('admin.layouts.app')

@section('title', 'Blog tags')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    @include('admin.partials.search', ['search' => $search])
    @can('create blog tags')
      <a class="adm-btn ink" href="{{ route('admin.blog.tags.create') }}"><i class="fa-solid fa-plus"></i>New tag</a>
    @endcan
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Name</th><th>Slug</th><th>Posts</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($tags as $tag)
          <tr>
            <td><b>{{ $tag->name }}</b></td>
            <td><code>{{ $tag->slug }}</code></td>
            <td>{{ $tag->blogs_count }}</td>
            <td>@include('admin.partials.status', ['active' => $tag->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $tag->name,
              'edit' => auth()->user()->can('edit blog tags') ? route('admin.blog.tags.edit', $tag) : null,
              'delete' => auth()->user()->can('delete blog tags') ? route('admin.blog.tags.destroy', $tag) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="5" class="adm-empty">No tags yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $tags->links() }}
</div>
@endsection
