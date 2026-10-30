@extends('admin.layouts.app')

@section('title', 'Docs groups')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    @can('create docs')
      <a class="adm-btn ink" href="{{ route('admin.docs.groups.create') }}"><i class="fa-solid fa-plus"></i>New group</a>
    @endcan
    <small>The headings of the /docs sidebar. Lower order numbers come first; a group without active pages is hidden.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Group</th><th>Pages</th><th>Order</th><th></th></tr></thead>
      <tbody>
        @forelse ($groups as $group)
          <tr>
            <td><b>{{ $group->name }}</b> @if ($group->name_si)<small lang="si">{{ $group->name_si }}</small>@endif</td>
            <td>{{ $group->pages_count }}</td>
            <td>{{ $group->sort_order }}</td>
            <td>@include('admin.partials.actions', [
              'label' => $group->name,
              'edit' => auth()->user()->can('edit docs') ? route('admin.docs.groups.edit', $group) : null,
              'delete' => auth()->user()->can('delete docs') && ! $group->pages_count ? route('admin.docs.groups.destroy', $group) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="4" class="adm-empty">No groups yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
