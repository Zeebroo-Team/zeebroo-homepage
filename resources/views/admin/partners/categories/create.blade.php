@extends('admin.layouts.app')

@section('title', 'New partner category')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.partner-categories.store') }}">
  @csrf
  @include('admin.partners.categories.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.partner-categories.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Create category</button>
  </div>
</form>
@endsection
