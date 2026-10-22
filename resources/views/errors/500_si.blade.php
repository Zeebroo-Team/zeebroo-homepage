@extends('errors.layout')

@section('title', 'සේවාදායක දෝෂය')
@section('code', '500')
@section('heading', 'අපගේ පැත්තෙන් දෝෂයක් සිදු විය.')
@section('message', 'අනපේක්ෂිත දෝෂයක් නිසා මෙම පිටුව පූරණය කළ නොහැකි විය. මිනිත්තු කිහිපයකින් නැවත උත්සාහ කරන්න. ගැටලුව දිගටම පවතී නම් අපට දන්වන්න.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->current() }}">නැවත උත්සාහ කරන්න <i class="fa-solid fa-rotate-right"></i></a>
  <a class="btn btn-line" href="{{ route('home') }}">මුල් පිටුවට</a>
@endsection
