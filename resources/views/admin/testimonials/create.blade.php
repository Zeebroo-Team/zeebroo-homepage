@extends('admin.layouts.app')

@section('title', 'New testimonial')

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
  @csrf
  @include('admin.testimonials.partials.form', ['submit' => 'Create testimonial'])
</form>
@endsection
