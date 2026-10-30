@extends('admin.layouts.app')

@section('title', 'Edit docs group')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.docs.groups.update', $group) }}">
  @csrf
  @method('PUT')
  @include('admin.docs.groups.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.docs.groups.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Save changes</button>
  </div>
</form>
@endsection
