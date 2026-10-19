@extends('layouts.frontend')

@section('title', 'Contact Zeebroo: talk to our team')
@section('description', 'Questions about Zeebroo POS, pricing or a demo? Send us a message and our team will get back to you.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
    @include('frontend.contact.contact')
@endsection
