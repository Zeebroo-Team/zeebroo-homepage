@extends('admin.layouts.app')

@section('title', 'New docs group')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.docs.groups.store') }}">
  @csrf
  @include('admin.docs.groups.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.docs.groups.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Create group</button>
  </div>
</form>
@endsection
