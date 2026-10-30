@extends('admin.layouts.app')

@section('title', 'SEO pages')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <small>The title and description shown in Google, and the image shown when a page is shared on WhatsApp, Facebook, LinkedIn or X. Empty fields keep the page's built-in text and the default share image.</small>
  </div>

  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Page</th><th>Meta title</th><th>Share image</th><th>Updated</th><th></th></tr></thead>
      <tbody>
        @foreach ($pages as $page)
          <tr>
            <td>
              <div class="adm-post">
                <img src="{{ $page->og_image_url ?: asset(config('social.default.image')) }}" alt="">
                <div>
                  <b>{{ $page->name }}</b>
                  <small><a href="{{ $page->url }}" target="_blank" rel="noopener">{{ $page->url }}</a></small>
                </div>
              </div>
            </td>
            <td>{{ $page->meta_title ?: 'Built-in title' }}</td>
            <td>@include('admin.partials.status', ['active' => (bool) $page->og_image_path, 'label' => $page->og_image_path ? 'Custom' : 'Default'])</td>
            <td>{{ $page->updated_at?->diffForHumans() ?? 'Never' }}</td>
            <td>@include('admin.partials.actions', [
              'label' => $page->name,
              'edit' => auth()->user()->can('edit seo') ? route('admin.seo.pages.edit', $page->key) : null,
              'delete' => null,
            ])</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
