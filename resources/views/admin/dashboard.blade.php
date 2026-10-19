@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
  $user = auth()->user();
  $hour = now()->hour;
  $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
  $days = \App\Services\DashboardService::ENQUIRY_DAYS;

  $shortcuts = array_values(array_filter([
    $user->can('create blogs') ? ['New post', 'fa-pen-to-square', route('admin.blog.posts.create'), 'c p'] : null,
    $user->can('view enquiries') ? ['Enquiries', 'fa-inbox', route('admin.enquiries.index'), 'g e'] : null,
    $user->can('create features') ? ['New feature', 'fa-layer-group', route('admin.features.create'), 'c f'] : null,
    $user->can('create industries') ? ['New industry', 'fa-briefcase', route('admin.industries.create'), 'c i'] : null,
    $user->can('create testimonials') ? ['New testimonial', 'fa-comment-dots', route('admin.testimonials.create'), 'c t'] : null,
    $user->can('create partners') ? ['New partner', 'fa-handshake', route('admin.partners.create'), 'c a'] : null,
  ]));
@endphp

{{-- summary --}}
<section class="adm-hero">
  <div class="adm-hero-text">
    <small>{{ now()->format('l, j F Y') }}</small>
    <h2>{{ $greeting }}, {{ \Illuminate\Support\Str::before($user->name, ' ') ?: $user->name }}</h2>
    <p>
      @if ($enquiries)
        You received <b>{{ $enquiries['period'] }} {{ \Illuminate\Support\Str::plural('enquiry', $enquiries['period']) }}</b> in the last {{ $days }} days{{ $enquiries['trend'] !== null ? ', '.($enquiries['trend'] >= 0 ? 'up ' : 'down ').abs($enquiries['trend'])."% on the {$days} days before" : '' }}.
        <b>{{ $enquiries['open'] }}</b> {{ $enquiries['open'] === 1 ? 'is' : 'are' }} still open.
      @endif
      @if ($blog)
        The blog has <b>{{ $blog['published'] }} live {{ \Illuminate\Support\Str::plural('post', $blog['published']) }}</b>{{ $blog['scheduled'] ? " and {$blog['scheduled']} scheduled" : '' }},
        with {{ $blog['this_month'] }} published this month.
      @endif
      @if (! $enquiries && ! $blog)
        Here is a quick look at the website content you manage.
      @endif
    </p>
  </div>
  <div class="adm-todo">
    <b class="adm-todo-h"><i class="fa-solid fa-list-check"></i>Needs your attention</b>
    @forelse ($attention as $item)
      <a href="{{ $item['url'] }}" class="adm-todo-item {{ $item['tone'] }}"><i class="fa-solid {{ $item['icon'] }}"></i><span>{{ $item['text'] }}</span><i class="fa-solid fa-arrow-right"></i></a>
    @empty
      <p class="adm-todo-done"><i class="fa-solid fa-circle-check"></i>All caught up. Nothing needs you right now.</p>
    @endforelse
  </div>
</section>

{{-- shortcuts --}}
@if ($shortcuts)
  <nav class="adm-quick" aria-label="Quick actions">
    @foreach ($shortcuts as [$label, $icon, $url, $key])
      <a href="{{ $url }}" data-key="{{ $key }}" data-key-label="{{ $label }}"><i class="fa-solid {{ $icon }}"></i><span>{{ $label }}</span><kbd>{{ $key }}</kbd></a>
    @endforeach
    <button type="button" class="adm-quick-help" data-shortcut-help><i class="fa-regular fa-keyboard"></i><span>Shortcuts</span><kbd>?</kbd></button>
  </nav>
@endif

{{-- headline numbers --}}
<div class="adm-stats">
  @if ($enquiries)
    <a class="adm-card adm-stat" href="{{ route('admin.enquiries.index') }}">
      <small>Enquiries · {{ $days }} days</small><b>{{ $enquiries['period'] }}</b>
      @if ($enquiries['trend'] !== null)
        <em @class(['adm-trend', 'up' => $enquiries['trend'] > 0, 'down' => $enquiries['trend'] < 0])><i class="fa-solid {{ $enquiries['trend'] >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>{{ $enquiries['trend'] > 0 ? '+' : '' }}{{ $enquiries['trend'] }}% vs previous {{ $days }} days</em>
      @else
        <em class="adm-trend">{{ $enquiries['total'] }} all time</em>
      @endif
    </a>
    <a class="adm-card adm-stat" href="{{ route('admin.enquiries.index', ['status' => \App\Models\Enquiry::STATUS_NEW]) }}">
      <small>Open enquiries</small><b>{{ $enquiries['open'] }}</b>
      <em class="adm-trend">{{ $enquiries['new'] }} new · {{ $enquiries['open'] - $enquiries['new'] }} in progress</em>
    </a>
  @endif
  @if ($blog)
    <a class="adm-card adm-stat" href="{{ route('admin.blog.posts.index') }}">
      <small>Live posts</small><b>{{ $blog['published'] }}</b>
      <em class="adm-trend">{{ $blog['scheduled'] }} scheduled · {{ $blog['drafts'] }} drafts</em>
    </a>
    <a class="adm-card adm-stat" href="{{ route('admin.blog.posts.index') }}">
      <small>Blog library</small><b>{{ $blog['total'] }}</b>
      <em class="adm-trend">{{ $blog['categories'] }} categories · {{ $blog['tags'] }} tags</em>
    </a>
  @endif
</div>

{{-- analytics --}}
@if ($enquiries)
  <div class="adm-grid">
    <div class="adm-card">
      <div class="adm-card-h">
        <h2>Enquiries per day</h2>
        <a class="adm-link" href="{{ route('admin.enquiries.index') }}">View all <i class="fa-solid fa-arrow-right"></i></a>
        <small>Contact form messages over the last {{ $days }} days. Hover a bar for the day's count.</small>
      </div>
      @include('admin.partials.bar-chart', ['bars' => $enquiries['daily'], 'unit' => 'enquiries', 'caption' => "Enquiries per day, last {$days} days"])
      <dl class="adm-facts">
        <div><dt>Today</dt><dd>{{ $enquiries['today'] }}</dd></div>
        <div><dt>Last 7 days</dt><dd>{{ $enquiries['week'] }}</dd></div>
        <div><dt>Daily average</dt><dd>{{ $enquiries['average'] }}</dd></div>
        <div>
          <dt>Busiest day</dt>
          <dd>{{ $enquiries['busiest'] ? $enquiries['busiest']['label'] : '—' }}@if ($enquiries['busiest']) <small>{{ $enquiries['busiest']['value'] }} received</small>@endif</dd>
        </div>
        <div class="wide">
          <dt>Handled <small>in progress or resolved, spam excluded</small></dt>
          <dd>{{ $enquiries['handled_rate'] !== null ? $enquiries['handled_rate'].'%' : '—' }}</dd>
          <i><em style="width: {{ $enquiries['handled_rate'] ?? 0 }}%"></em></i>
        </div>
      </dl>
    </div>
    <div class="adm-card">
      <div class="adm-card-h"><h2>Enquiry breakdown</h2><small>All {{ $enquiries['total'] }} enquiries by status and by topic.</small></div>
      <div class="adm-bars">
        @foreach ($enquiries['statuses'] as $row)
          <a href="{{ route('admin.enquiries.index', ['status' => $row['key']]) }}">
            <span>{{ $row['label'] }}</span><b>{{ $row['value'] }}</b>
            <i><em class="adm-pill-{{ $row['key'] }}" style="width: {{ $row['share'] }}%"></em></i>
          </a>
        @endforeach
      </div>
      <div class="adm-bars">
        @foreach ($enquiries['topics'] as $row)
          <a href="{{ route('admin.enquiries.index', ['topic' => $row['key']]) }}">
            <span>{{ $row['label'] }}</span><b>{{ $row['value'] }}</b>
            <i><em style="width: {{ $row['share'] }}%"></em></i>
          </a>
        @endforeach
      </div>
    </div>
  </div>
@endif

@if ($blog || $website)
  <div class="adm-grid">
    @if ($blog)
      <div class="adm-card">
        <div class="adm-card-h">
          <h2>Posts published</h2>
          <a class="adm-link" href="{{ route('admin.blog.posts.index') }}">All posts <i class="fa-solid fa-arrow-right"></i></a>
          <small>Live posts per month, last {{ \App\Services\DashboardService::POST_MONTHS }} months.</small>
        </div>
        @include('admin.partials.bar-chart', ['bars' => $blog['monthly'], 'unit' => 'posts', 'caption' => 'Posts published per month'])
        @if ($blog['upcoming']->isNotEmpty())
          <div class="adm-mini-list">
            <b class="adm-mini-h">Coming up</b>
            @foreach ($blog['upcoming'] as $post)
              <a href="{{ $user->can('edit blogs') ? route('admin.blog.posts.edit', $post) : route('admin.blog.posts.index') }}">
                <i class="fa-regular fa-calendar"></i><span>{{ $post->title }}</span><small>{{ $post->published_at->format('M j, H:i') }}</small>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    @endif
    @if ($website)
      <div class="adm-card">
        <div class="adm-card-h"><h2>Website content</h2><small>How much of each section is live on the site.</small></div>
        <div class="adm-bars">
          @foreach ($website as $section)
            <a href="{{ $section['url'] }}">
              <span><i class="fa-solid {{ $section['icon'] }}"></i>{{ $section['label'] }}</span>
              <b>{{ $section['active'] }}<small> / {{ $section['total'] }} live</small></b>
              <i><em class="ok" style="width: {{ $section['total'] ? round($section['active'] / $section['total'] * 100) : 0 }}%"></em></i>
            </a>
          @endforeach
        </div>
        <a class="adm-btn line" href="{{ route('home') }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i>Open website</a>
      </div>
    @endif
  </div>
@endif

@if ($enquiries)
  <div class="adm-card">
    <div class="adm-card-h">
      <h2>Latest enquiries</h2>
      <a class="adm-link" href="{{ route('admin.enquiries.index') }}">Open inbox <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="adm-table-wrap">
      <table class="adm-table">
        <thead><tr><th>From</th><th>Topic</th><th>Received</th><th>Status</th></tr></thead>
        <tbody>
          @forelse ($enquiries['recent'] as $enquiry)
            <tr @class(['adm-unread' => $enquiry->status === \App\Models\Enquiry::STATUS_NEW])>
              <td><a href="{{ route('admin.enquiries.show', $enquiry) }}"><b>{{ $enquiry->name }}</b><small>{{ $enquiry->business ?: $enquiry->email }}</small></a></td>
              <td>{{ $enquiry->topic_label }}</td>
              <td title="{{ $enquiry->created_at->format('M j, Y H:i') }}">{{ $enquiry->created_at->diffForHumans() }}</td>
              <td>@include('admin.enquiries.partials.status')</td>
            </tr>
          @empty
            <tr><td colspan="4" class="adm-empty">No enquiries yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endif

@if ($blog)
  <div class="adm-card">
    <div class="adm-card-h">
      <h2>Latest posts</h2>
      @can('create blogs')
        <a class="adm-btn ink" href="{{ route('admin.blog.posts.create') }}"><i class="fa-solid fa-plus"></i>New post</a>
      @endcan
    </div>
    @include('admin.blog.posts.partials.table', ['blogs' => $blog['latest']])
  </div>
@endif
@endsection
