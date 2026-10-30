@extends('admin.layouts.app')

@section('title', 'New docs page')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.docs.pages.store') }}">
  @csrf
  @include('admin.docs.pages.partials.form', ['submit' => 'Create page'])
</form>
@endsection
