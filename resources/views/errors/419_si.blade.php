@extends('errors.layout')

@section('title', 'සැසිය කල් ඉකුත් විය')
@section('code', '419')
@section('heading', 'ඔබගේ සැසිය කල් ඉකුත් වී ඇත.')
@section('message', 'පිටුව බොහෝ වේලාවක් විවෘතව තිබූ නිසා ඔබගේ පෝරමය යැවීමට නොහැකි විය. ආපසු ගොස් පිටුව නැවත පූරණය කර නැවත උත්සාහ කරන්න.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->previous() }}">ආපසු ගොස් නැවත උත්සාහ කරන්න <i class="fa-solid fa-rotate-right"></i></a>
  <a class="btn btn-line" href="{{ route('home') }}">මුල් පිටුවට</a>
@endsection
