@extends('errors.layout')

@section('title', 'Request error')
@section('code', $exception->getStatusCode())
@section('heading', 'Something is not right.')
@section('message', 'We could not complete that request. Check the address and try again.')
