@extends('admin.layouts.app')

@section('title', 'New category')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.blog.categories.store') }}">
  @csrf
  @include('admin.blog.categories.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.blog.categories.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Create category</button>
  </div>
</form>
@endsection
