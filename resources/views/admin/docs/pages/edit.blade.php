@extends('admin.layouts.app')

@section('title', 'Edit docs page')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.docs.pages.update', $page) }}">
  @csrf
  @method('PUT')
  @include('admin.docs.pages.partials.form', ['submit' => 'Save changes'])
</form>
@endsection
