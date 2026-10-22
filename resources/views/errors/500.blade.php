@extends('errors.layout')

@section('title', 'Server error')
@section('code', '500')
@section('heading', 'Something broke on our side.')
@section('message', 'An unexpected error stopped this page from loading. Please try again in a few minutes. If it keeps happening, let us know.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->current() }}">Try again <i class="fa-solid fa-rotate-right"></i></a>
  <a class="btn btn-line" href="{{ route('home') }}">Back to home</a>
@endsection
