@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
@endsection

@include('vendor.event.form')
