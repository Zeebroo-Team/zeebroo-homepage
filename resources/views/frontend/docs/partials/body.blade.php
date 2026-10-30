{{-- A docs page body from the database (DocLibrary::body): intro, each section, then outro. Admin-written HTML, cleaned on save by DocHtmlSanitizer. --}}
{!! $page->intro !!}
@foreach ($page->sections as $section)
@if ($section->is_custom)
{!! $section->body !!}
@else
<div class="doc-sec">
  <h3 id="{{ $section->anchor }}">{{ $section->heading }}</h3>
  {!! $section->body !!}
</div>
@endif
@endforeach
{!! $page->outro !!}
