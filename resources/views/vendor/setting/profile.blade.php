@extends('layouts.vendor')

@section('styles')
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
          <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Vendors</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                </ol>
            </div>
        </div>
        <div class="row mt-4">
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
            <div class="EventForm">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="main-title mb-5">Profile Information</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" class="form-control" id="Name" name="name" value="{{ $user->name }}" readonly>
                            <input type="hidden" id="profile_id" name="profile_id" value="{{ !is_null($user->vendor) ? $user->vendor->id : '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ !is_null($user->vendor) ? $user->vendor->phone : '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="address" name="address" value="{{ !is_null($user->vendor) ? $user->vendor->address : '' }}" readonly>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-map-marker"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" class="form-control" id="gender" name="gender" value="{{ !is_null($user->vendor) ? $user->vendor->gender : '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_birth">Date of Birth</label>
                            <input type="date" value="{{ !is_null($user->vendor) ? $user->vendor->date_birth : date('Y-m-d') }}" id="date_birth" name="date_birth" class="form-control" readonly/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endsection