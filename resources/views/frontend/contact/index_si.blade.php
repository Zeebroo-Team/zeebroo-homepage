@extends('layouts.frontend')

@section('title', 'Zeebroo අමතන්න: අපේ කණ්ඩායම හා කතා කරන්න')
@section('description', 'Zeebroo POS, මිල ගණන් හෝ ආදර්ශනයක් ගැන ප්‍රශ්න තිබේද? අපට පණිවිඩයක් එවන්න, අපේ කණ්ඩායම ඔබට පිළිතුරු දෙනු ඇත.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
    @include('frontend.contact.contact')
@endsection
