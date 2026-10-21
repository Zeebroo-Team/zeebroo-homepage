@extends('layouts.frontend')

@section('title', 'Zeebroo අමතන්න: අපගේ කණ්ඩායම සමඟ කතා කරන්න')
@section('description', 'Zeebroo POS ගැන, මිල ගණන් ගැන හෝ Demo එකක් ගැන දැනගන්න ඕනද? අපට පණිවිඩයක් එවන්න. අපගේ කණ්ඩායම ඉක්මනින්ම ඔබව සම්බන්ධ කරගනීවි.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
    @include('frontend.contact.contact')
@endsection
