@extends('errors.layout')

@section('title', 'Session expired')
@section('code', '419')
@section('heading', 'Your session expired.')
@section('message', 'The page was open a little too long, so we could not send your form. Go back, refresh the page and try again.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->previous() }}">Go back and retry <i class="fa-solid fa-rotate-right"></i></a>
  <a class="btn btn-line" href="{{ route('home') }}">Back to home</a>
@endsection
