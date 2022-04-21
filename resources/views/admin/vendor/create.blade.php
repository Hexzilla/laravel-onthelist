@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Vendors</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Vendor</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ route('admin.vendors.update', $user->id) }}" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    @isset($user)
                      @method('PUT')
                    @endisset
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-5">Vendor Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" id="Name" name="name" value="{{ $user->name }}">
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                        <input type="hidden" id="profile_id" name="profile_id" value="{{ !is_null($user->vendor) ? $user->vendor->id : '' }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ !is_null($user->vendor) ? $user->vendor->phone : '' }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="file-field addEventHeader">
                                    <div class="addEvent-icon" id="header-image-uploader">
                                        <i class="mdi mdi-image-multiple"></i>
                                        <span>Add Profile Image</span>
                                        <span id="header-image-file-name">{{$user->vendor ? $user->vendor->image_path : ''}}</span>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class="">
                                            <input id="header-image" class="d-none" type="file" name="profile_image"/>
                                            <p>Upload an Image no larger than 10mb in jpeg, png or gif format. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="address" name="address" value="{{ !is_null($user->vendor) ? $user->vendor->address : '' }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-map-marker"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female" {{ (!is_null($user->vendor) && $user->vendor->gender === "Female") ? 'selected' : ''}}>Female</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_birth">Date of Birth</label>
                                <input type="date" value="{{ !is_null($user->vendor) ? $user->vendor->date_birth : date('Y-m-d') }}" id="date_birth" name="date_birth" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
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

@section('scripts')
<script>
    $("#header-image-uploader").on('click', function(){
        $("#header-image").click();
    });
    $("#header-image").on('change', function(){
        $("#header-image-file-name").text($(this)[0].files[0].name);
    });
</script>
@endsection