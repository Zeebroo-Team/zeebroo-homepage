@extends('errors.layout')

@section('title', 'Server error')
@section('code', $exception->getStatusCode())
@section('heading', 'Something went wrong.')
@section('message', 'We hit a problem on our side. Please try again in a few minutes.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->current() }}">Try again <i class="fa-solid fa-rotate-right"></i></a>
  <a class="btn btn-line" href="{{ route('home') }}">Back to home</a>
@endsection
