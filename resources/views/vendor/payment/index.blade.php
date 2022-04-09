@extends('layouts.vendor')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Events</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Payments</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-5">Payment Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mt-5 mb-3">Name on Account</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="FirstName">First Name</label>
                                <input type="text" class="form-control" id="FirstName" name="firstname" value="{{ old('firstname') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="LastName">Last Name</label>
                                <input type="text" class="form-control" id="LastName" name="lastname" value="{{ old('name') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h4 class="main-title mt-5 mb-3">Address</h4>
                        </div>
                    </div>
                    <div class="row no-input-border">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Address">Address</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="Address" name="address" value="{{ old('address') }}" >
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-map-marker"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group border-input">
                                <label for="City">Town/City *</label>
                                <input type="text" class="form-control" placeholder="" id="City" name="city" value="{{ old('city') }}">
                            </div>
                            <div class="form-group border-input">
                                <label for="Postcode">Postcode *</label>
                                <input type="text" class="form-control" placeholder="" id="Postcode" name="postcode" value="{{ old('postcode') }}">
                            </div>
                            <div class="form-group border-input">
                                <label for="Phone">Phone Number *</label>
                                <input type="text" class="form-control" placeholder="" id="Phone" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h4 class="main-title mt-5 mb-3">Bank Account Details</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="BankName">Bank Name</label>
                                <input type="text" class="form-control" id="BankName" name="bankname" value="{{ old('bankname') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="SortCode">Sort Code</label>
                                <input type="text" class="form-control" id="SortCode" name="sortcode" value="{{ old('sortcode') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ReCode">Re-enter Sort Code</label>
                                <input type="text" class="form-control" id="Recode" name="recode" value="{{ old('recode') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Account">Account Number</label>
                                <input type="text" class="form-control" id="Account" name="account_number" value="{{ old('account_number') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ReAccount">Re-enter Account Number</label>
                                <input type="text" class="form-control" id="ReAccount" name="re_account_number" value="{{ old('re_account_number') }}" />
                            </div>
                        </div>
                        <div class="col-md-6 my-5">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit<i class="mdi mdi-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>	
            </div>
        </div>
    </div>
</div>
@endsection
