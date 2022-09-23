@extends('layouts.customer')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ $action }}" class="EventForm needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-3">Affiliate Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="code">Code of Your Affiliate Program</label>
                                <input type="text" class="form-control" id="code" name="code" value="{{ $rep ? $rep->code : old('code') }}" required/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                            <div class="form-group">
                                <label for="referral_fee">Referral Fee</label>
                                <input type="number" class="form-control" id="referral_fee" min="0" max="100" step="any" name="referral_fee" value="{{ $rep ? $rep->referral_fee : old('referral_fee')}}" required/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                            <div class="form-group">
                                <label for="additional_notes">Additional Notes</label>
                                <textarea class="form-control" rows="5" id="additional_notes" name="additional_note" value="{{ $rep ? $rep->additional_note : old('additional_note') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-6">
                            <button id="submit-button" type="submit" class="btn btn-primary">Create Affiliate Program</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap&libraries=places&v=weekly" 
    async
></script>
@endsection