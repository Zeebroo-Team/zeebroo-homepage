@extends('admin.layouts.app')

@section('title', 'New feature')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.features.store') }}" enctype="multipart/form-data">
  @csrf
  @include('admin.features.partials.form', ['submit' => 'Create feature'])
</form>
@endsection
