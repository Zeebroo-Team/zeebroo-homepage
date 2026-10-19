@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <form class="adm-filter" method="get">
      <div class="adm-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search name or position" aria-label="Search testimonials">
      </div>
      <button type="submit" class="adm-btn line">Filter</button>
    </form>
    @can('create testimonials')
      <a class="adm-btn ink" href="{{ route('admin.testimonials.create') }}"><i class="fa-solid fa-plus"></i>New testimonial</a>
    @endcan
    <small>Featured testimonials show on the home page; every active one is listed on /testimonials. Lower order numbers come first.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Customer</th><th>Rating</th><th>Order</th><th>Home page</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($testimonials as $testimonial)
          <tr>
            <td>
              <div class="adm-post">
                @if ($testimonial->image_url)
                  <img src="{{ $testimonial->image_url }}" alt="">
                @else
                  <span>{{ $testimonial->initials }}</span>
                @endif
                <div>
                  <b>{{ $testimonial->name }}</b>
                  <small>{{ $testimonial->position ?: Str::limit($testimonial->message, 60) }}</small>
                </div>
              </div>
            </td>
            <td><span class="adm-stars" aria-label="{{ $testimonial->rating }} out of 5 stars">@for ($i = 1; $i <= 5; $i++)<i @class(['fa-solid fa-star', 'off' => $i > $testimonial->rating])></i>@endfor</span></td>
            <td>{{ $testimonial->sort_order }}</td>
            <td>@include('admin.partials.status', ['active' => $testimonial->is_featured, 'label' => $testimonial->is_featured ? 'Featured' : 'No'])</td>
            <td>@include('admin.partials.status', ['active' => $testimonial->is_active])</td>
            <td>@include('admin.partials.actions', [
              'label' => $testimonial->name,
              'edit' => auth()->user()->can('edit testimonials') ? route('admin.testimonials.edit', $testimonial) : null,
              'delete' => auth()->user()->can('delete testimonials') ? route('admin.testimonials.destroy', $testimonial) : null,
            ])</td>
          </tr>
        @empty
          <tr><td colspan="6" class="adm-empty">No testimonials yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $testimonials->links() }}
</div>
@endsection
