@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="adm-stats">
  @foreach ($stats as $label => $value)
    <div class="adm-card adm-stat"><small>{{ $label }}</small><b>{{ $value }}</b></div>
  @endforeach
</div>

<div class="adm-card">
  <div class="adm-card-h">
    <h2>Latest posts</h2>
    @can('create blogs')
      <a class="adm-btn ink" href="{{ route('admin.blog.posts.create') }}"><i class="fa-solid fa-plus"></i>New post</a>
    @endcan
  </div>
  @include('admin.blog.posts.partials.table', ['blogs' => $latest])
</div>
@endsection
