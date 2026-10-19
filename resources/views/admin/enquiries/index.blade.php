@extends('admin.layouts.app')

@section('title', 'Enquiries')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <form class="adm-filter" method="get">
      <div class="adm-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search name, email or business" aria-label="Search enquiries">
      </div>
      <select name="status" aria-label="Status">
        <option value="">All statuses</option>
        @foreach (\App\Models\Enquiry::STATUSES as $key => $label)
          <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
        @endforeach
      </select>
      <select name="topic" aria-label="Topic">
        <option value="">All topics</option>
        @foreach (\App\Models\Enquiry::TOPICS as $key => $label)
          <option value="{{ $key }}" @selected($topic === $key)>{{ $label }}</option>
        @endforeach
      </select>
      <button type="submit" class="adm-btn line">Filter</button>
    </form>
    <small>Messages sent through the contact form on /contact, newest first. Open one to read it, add notes and change its status.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>From</th><th>Topic</th><th>Received</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($enquiries as $enquiry)
          <tr @class(['adm-unread' => $enquiry->status === \App\Models\Enquiry::STATUS_NEW])>
            <td>
              <a href="{{ route('admin.enquiries.show', $enquiry) }}">
                <b>{{ $enquiry->name }}</b>
                <small>{{ $enquiry->email }}@if ($enquiry->business) · {{ $enquiry->business }}@endif</small>
                <small>{{ Str::limit($enquiry->message, 80) }}</small>
              </a>
            </td>
            <td>{{ $enquiry->topic_label }}</td>
            <td>{{ $enquiry->created_at->format('M j, Y') }}<small>{{ $enquiry->created_at->format('H:i') }}</small></td>
            <td>
              @can('edit enquiries')
                <form method="post" action="{{ route('admin.enquiries.update', $enquiry) }}">
                  @csrf
                  @method('PATCH')
                  <select name="status" class="adm-status-sel is-{{ $enquiry->status }}" data-autosubmit aria-label="Status of {{ $enquiry->name }}'s enquiry">
                    @foreach (\App\Models\Enquiry::STATUSES as $key => $label)
                      <option value="{{ $key }}" @selected($enquiry->status === $key)>{{ $label }}</option>
                    @endforeach
                  </select>
                </form>
              @else
                @include('admin.enquiries.partials.status', ['enquiry' => $enquiry])
              @endcan
            </td>
            <td>
              <div class="adm-row-actions">
                <a class="adm-icon-btn" href="{{ route('admin.enquiries.show', $enquiry) }}" title="Open" aria-label="Open enquiry from {{ $enquiry->name }}"><i class="fa-solid fa-eye"></i></a>
                @can('delete enquiries')
                  <form method="post" action="{{ route('admin.enquiries.destroy', $enquiry) }}" data-confirm="Delete the enquiry from &quot;{{ $enquiry->name }}&quot;? This cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="adm-icon-btn danger" title="Delete" aria-label="Delete enquiry from {{ $enquiry->name }}"><i class="fa-solid fa-trash"></i></button>
                  </form>
                @endcan
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="adm-empty">No enquiries yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $enquiries->links() }}
</div>
@endsection
