@extends('admin.layouts.app')

@section('title', 'Edit partner')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  @include('admin.partners.partials.form', ['submit' => 'Save changes'])
</form>
@endsection
