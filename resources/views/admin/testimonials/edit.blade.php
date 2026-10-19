@extends('admin.layouts.app')

@section('title', 'Edit testimonial')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  @include('admin.testimonials.partials.form', ['submit' => 'Save changes'])
</form>
@endsection
