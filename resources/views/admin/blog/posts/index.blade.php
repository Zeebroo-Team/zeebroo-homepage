@extends('admin.layouts.app')

@section('title', 'Blog posts')

@section('content')
<div class="adm-card">
  <div class="adm-card-h">
    <form class="adm-filter" method="get">
      <div class="adm-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search titles" aria-label="Search titles">
      </div>
      <select name="category" aria-label="Category">
        <option value="">All categories</option>
        @foreach ($categories as $id => $name)
          <option value="{{ $id }}" @selected($categoryId === $id)>{{ $name }}</option>
        @endforeach
      </select>
      <button type="submit" class="adm-btn line">Filter</button>
    </form>
    @can('create blogs')
      <a class="adm-btn ink" href="{{ route('admin.blog.posts.create') }}"><i class="fa-solid fa-plus"></i>New post</a>
    @endcan
  </div>

  @include('admin.blog.posts.partials.table', ['blogs' => $blogs])

  {{ $blogs->links() }}
</div>
@endsection
