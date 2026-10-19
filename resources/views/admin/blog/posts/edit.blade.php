@extends('admin.layouts.app')

@section('title', 'Edit post')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.blog.posts.update', $blog) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  @include('admin.blog.posts.partials.form', ['submit' => 'Save changes'])
</form>
@endsection
