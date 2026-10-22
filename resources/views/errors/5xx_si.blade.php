@extends('errors.layout')

@section('title', 'සේවාදායක දෝෂය')
@section('code', $exception->getStatusCode())
@section('heading', 'යමක් වැරදී ගියේය.')
@section('message', 'අපගේ පැත්තෙන් ගැටලුවක් ඇති විය. මිනිත්තු කිහිපයකින් නැවත උත්සාහ කරන්න.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->current() }}">නැවත උත්සාහ කරන්න <i class="fa-solid fa-rotate-right"></i></a>
  <a class="btn btn-line" href="{{ route('home') }}">මුල් පිටුවට</a>
@endsection
