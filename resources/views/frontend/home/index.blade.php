@extends('layouts.frontend')


@section('content')
    @include('frontend.home.hero')
    @include('frontend.home.benefits')
    @include('frontend.home.modules')
    @include('frontend.home.finance')
    @include('frontend.home.industries')
    @include('frontend.home.steps')
    @include('frontend.home.manifesto')
    @include('frontend.home.faq')
    @include('frontend.home.cta')
    @include('frontend.home.temp')

 @endsection