@extends('admin.layouts.app')

@section('title', 'New post')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.blog.posts.store') }}" enctype="multipart/form-data">
  @csrf
  @include('admin.blog.posts.partials.form', ['submit' => 'Create post'])
</form>
@endsection
