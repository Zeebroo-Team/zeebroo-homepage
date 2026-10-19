@extends('admin.layouts.app')

@section('title', 'New partner')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
  @csrf
  @include('admin.partners.partials.form', ['submit' => 'Create partner'])
</form>
@endsection
