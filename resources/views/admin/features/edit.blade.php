@extends('admin.layouts.app')

@section('title', 'Edit feature')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.features.update', $feature) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  @include('admin.features.partials.form', ['submit' => 'Save changes'])
</form>
@endsection
