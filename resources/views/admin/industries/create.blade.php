@extends('admin.layouts.app')

@section('title', 'New industry')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.industries.store') }}" enctype="multipart/form-data">
  @csrf
  @include('admin.industries.partials.form', ['submit' => 'Create industry'])
</form>
@endsection
