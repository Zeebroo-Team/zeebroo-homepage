@extends('errors.layout')

@section('title', 'නඩත්තු කටයුතු')
@section('code', '503')
@section('heading', 'මිනිත්තු කිහිපයකින් නැවත පැමිණෙමු.')
@section('message', 'Zeebroo දැනට කෙටි යාවත්කාලීන කිරීමක් සිදු කරමින් පවතී. වෙබ් අඩවිය ඉක්මනින් නැවත ක්‍රියාත්මක වේ. ඔබගේ ඉවසීමට ස්තූතියි.')

@section('actions')
  <a class="btn btn-ink" href="{{ url()->current() }}">නැවත උත්සාහ කරන්න <i class="fa-solid fa-rotate-right"></i></a>
@endsection
