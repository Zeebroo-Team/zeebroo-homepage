@extends('admin.layouts.app')

@section('title', 'Edit tag')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.blog.tags.update', $tag) }}">
  @csrf
  @method('PUT')
  @include('admin.blog.tags.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.blog.tags.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Save changes</button>
  </div>
</form>
@endsection
