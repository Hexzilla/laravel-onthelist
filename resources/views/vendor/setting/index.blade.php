@extends('layouts.vendor')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Vendors</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Setting</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ route('vendors.setting.contact') }}" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-5">Contact Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" id="Name" name="name" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ !is_null($user->userProfile) ? $user->userProfile->phone : '' }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="file-field addEventHeader">
                                    <div class="addEvent-icon" id="header-image-uploader">
                                        <i class="mdi mdi-image-multiple"></i>
                                        <span>Add Profile Image</span>
                                        <span id="header-image-file-name"></span>
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
                                    <input type="text" class="form-control" id="address" name="address" value="{{ !is_null($user->userProfile) ? $user->userProfile->address : '' }}">
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
                                    <option value="Female" {{ (!is_null($user->userProfile) && $user->userProfile->gender === "Female") ? 'selected' : ''}}>Female</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_birth">Date of Birth</label>
                                <input type="date" value="{{ !is_null($user->userProfile) ? $user->userProfile->date_birth : date('Y-m-d') }}" id="date_birth" name="date_birth" class="form-control" />
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
                
                <form method="POST" action="{{ route('vendors.setting.password') }}" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-5">Change Password</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="CurrentPassword">Current Password</label>
                                <input type="password" class="form-control" id="Current" name="old_password" value="{{ old('old_password') }}" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="NewPassword">New Password</label>
                                <input type="password" class="form-control" id="NewPassword" name="password" value="{{ old('password') }}" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="NewPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="NewPassword" name="password_confirmation" value="{{ old('password_confirmation') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 my-5">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Change Password<i class="mdi mdi-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="EventForm">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-5">Close Account</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 my-5">
                            <div class="form-group">
                                <button class="btn btn-primary" onclick="openCloseModal()">Close Account<i class="mdi mdi-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#header-image-uploader").on('click', function(){
                $("#header-image").click();
            });
            $("#header-image").on('change', function(){
                $("#header-image-file-name").text($(this)[0].files[0].name);
            });
        });
        openCloseModal = () => {
            let url = "{{ route('vendors.setting.close') }}";
            $("#modal_delete").modal('show');
            $("#modal_delete .modal-title").text(`Close Account`);
            var content = '<button type="button" class="btn btn-info">';
                content += `<a href="${url}">`;
                content += "Yes</a></button>";
                content += '<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>';
            $("#modal_delete .modal-footer").html(content);
            $("#modal_delete .modal-body").text('Are you sure you want to close this account?');
        } 
    </script>
@endsection