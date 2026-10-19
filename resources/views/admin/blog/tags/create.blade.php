@extends('admin.layouts.app')

@section('title', 'New tag')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.blog.tags.store') }}">
  @csrf
  @include('admin.blog.tags.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.blog.tags.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Create tag</button>
  </div>
</form>
@endsection
