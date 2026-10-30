@extends('admin.layouts.app')

@section('title', 'New common task')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.docs.tasks.store') }}">
  @csrf
  @include('admin.docs.tasks.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.docs.tasks.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Create task</button>
  </div>
</form>
@endsection
