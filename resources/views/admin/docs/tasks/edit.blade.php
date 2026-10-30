@extends('admin.layouts.app')

@section('title', 'Edit common task')

@section('content')
<form class="adm-card adm-form" method="post" action="{{ route('admin.docs.tasks.update', $task) }}">
  @csrf
  @method('PUT')
  @include('admin.docs.tasks.partials.form')
  <div class="adm-form-foot">
    <a class="adm-btn line" href="{{ route('admin.docs.tasks.index') }}">Cancel</a>
    <button type="submit" class="adm-btn ink">Save changes</button>
  </div>
</form>
@endsection
