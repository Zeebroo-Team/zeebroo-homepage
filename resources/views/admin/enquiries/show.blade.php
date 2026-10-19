@extends('admin.layouts.app')

@section('title', 'Enquiry from '.$enquiry->name)

@section('content')
<a class="adm-note" href="{{ route('admin.enquiries.index') }}"><i class="fa-solid fa-arrow-left"></i>All enquiries</a>

<div class="adm-split">
  <div class="adm-split-main">
    <div class="adm-card">
      <div class="adm-card-h">
        <h2>{{ $enquiry->topic_label }}</h2>
        @include('admin.enquiries.partials.status', ['enquiry' => $enquiry])
        <small>Received {{ $enquiry->created_at->format('M j, Y \a\t H:i') }} ({{ $enquiry->created_at->diffForHumans() }})</small>
      </div>
      <div class="adm-message">{{ $enquiry->message }}</div>
      <div>
        <a class="adm-btn ink" href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode('Re: '.$enquiry->topic_label) }}"><i class="fa-solid fa-reply"></i>Reply by email</a>
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>Contact details</h2></div>
      <dl class="adm-dl">
        <dt>Name</dt><dd>{{ $enquiry->name }}</dd>
        <dt>Email</dt><dd><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd>
        <dt>Phone</dt><dd>@if ($enquiry->phone)<a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a>@else<span class="adm-muted">Not given</span>@endif</dd>
        <dt>Business</dt><dd>{{ $enquiry->business ?: '—' }}</dd>
        <dt>IP address</dt><dd><code>{{ $enquiry->ip_address ?: '—' }}</code></dd>
      </dl>
    </div>
  </div>

  <div class="adm-split-side">
    @can('edit enquiries')
      <form class="adm-card" method="post" action="{{ route('admin.enquiries.update', $enquiry) }}">
        @csrf
        @method('PATCH')
        <div class="adm-card-h"><h2>Status</h2></div>
        <label class="adm-field">
          <span>Status</span>
          <select name="status" @class(['bad' => $errors->has('status')])>
            @foreach (\App\Models\Enquiry::STATUSES as $key => $label)
              <option value="{{ $key }}" @selected(old('status', $enquiry->status) === $key)>{{ $label }}</option>
            @endforeach
          </select>
          @error('status')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
        <label class="adm-field">
          <span>Internal notes <em>only admins see these</em></span>
          <textarea name="notes" rows="5" maxlength="5000" @class(['bad' => $errors->has('notes')])>{{ old('notes', $enquiry->notes) }}</textarea>
          @error('notes')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
        <button type="submit" class="adm-btn ink wide">Save</button>
        <small class="adm-muted">Last updated {{ $enquiry->updated_at->diffForHumans() }}</small>
      </form>
    @elseif ($enquiry->notes)
      <div class="adm-card">
        <div class="adm-card-h"><h2>Internal notes</h2></div>
        <div class="adm-message">{{ $enquiry->notes }}</div>
      </div>
    @endcan

    @can('delete enquiries')
      <form class="adm-card" method="post" action="{{ route('admin.enquiries.destroy', $enquiry) }}" data-confirm="Delete the enquiry from &quot;{{ $enquiry->name }}&quot;? This cannot be undone.">
        @csrf
        @method('DELETE')
        <button type="submit" class="adm-btn line wide"><i class="fa-solid fa-trash"></i>Delete enquiry</button>
      </form>
    @endcan
  </div>
</div>
@endsection
