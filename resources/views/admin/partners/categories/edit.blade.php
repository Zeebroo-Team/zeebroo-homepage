@extends('admin.layouts.app')

@section('title', 'Edit partner category')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.partner-categories.update', $category) }}">
  @csrf
  @method('PUT')
  @include('admin.partners.categories.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.partner-categories.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Save changes</button>
  </div>
</form>
@endsection
