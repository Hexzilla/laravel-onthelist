@extends('layouts.vendor')

@section('styles')
    <link href="{{ secure_asset('css/vendor.css') }}" rel="stylesheet">
@endsection

@include('vendor.venue.form')