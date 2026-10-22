@extends('errors.layout')

@section('title', 'ඉල්ලීම් දෝෂය')
@section('code', $exception->getStatusCode())
@section('heading', 'යමක් වැරදී ඇත.')
@section('message', 'අපට එම ඉල්ලීම සම්පූර්ණ කිරීමට නොහැකි විය. ලිපිනය පරීක්ෂා කර නැවත උත්සාහ කරන්න.')
