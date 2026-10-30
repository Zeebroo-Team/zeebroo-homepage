@extends('admin.layouts.app')

@section('title', 'Docs common tasks')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    @can('create docs')
      <a class="adm-btn ink" href="{{ route('admin.docs.tasks.create') }}"><i class="fa-solid fa-plus"></i>New task</a>
    @endcan
    <small>Shortcut cards on the /docs home page, each linking to one section of a guide page. Lower order numbers come first.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Task</th><th>Links to</th><th>Order</th><th></th></tr></thead>
      <tbody>
        @forelse ($tasks as $task)
          <tr>
            <td>
              <div class="adm-post">
                <span><i class="fa-solid {{ $task->icon }}"></i></span>
                <div><b>{{ $task->title }}</b> @if ($task->title_si)<small lang="si">{{ $task->title_si }}</small>@endif</div>
              </div>
            </td>
            <td>
              {{ $task->page->title }}
              <small>{{ $task->page->sections->firstWhere('anchor', $task->anchor)?->heading ?? '#'.$task->anchor }}</small>
            </td>
            <td>{{ $task->sort_order }}</td>
            <td>@include('admin.partials.actions', [
              'label' => $task->title,
              'edit' => auth()->user()->can('edit docs') ? route('admin.docs.tasks.edit', $task) : null,
              'delete' => auth()->user()->can('delete docs') ? route('admin.docs.tasks.destroy', $task) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="4" class="adm-empty">No common tasks yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
