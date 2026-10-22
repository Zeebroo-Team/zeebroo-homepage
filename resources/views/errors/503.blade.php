@extends('errors.layout')

@section('title', 'Down for maintenance')
@section('code', '503')
@section('heading', 'Back in a few minutes.')
@section('message', 'Zeebroo is getting a quick update. The site will be back shortly. Thanks for your patience.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->current() }}">Try again <i class="fa-solid fa-rotate-right"></i></a>
@endsection
