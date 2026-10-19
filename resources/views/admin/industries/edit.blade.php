@extends('admin.layouts.app')

@section('title', 'Edit industry')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.industries.update', $industry) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  @include('admin.industries.partials.form', ['submit' => 'Save changes'])
</form>
@endsection
