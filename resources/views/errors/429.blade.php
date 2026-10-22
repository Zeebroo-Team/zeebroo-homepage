@extends('errors.layout')

@section('title', 'Too many requests')
@section('code', '429')
@section('heading', 'Slow down a little.')
@section('message', 'We have had too many requests from you in a short time. Wait a minute, then try again.')
