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
                                <input type="hidden" id="profile_id" name="profile_id" value="{{ !is_null($user->vendor) ? $user->vendor->id : '' }}">
                            </div>
                        </div>
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
                
                <form method="POST" action="{{ route('vendors.setting.password') }}" class="EventForm needs-validation" enctype="multipart/form-data">
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
                                <input type="password" class="form-control" id="current" name="old_password" value="{{ old('old_password') }}" required/>
                                <input type="hidden" id="old" value="{{$user->password}}"/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                                <span id="current_error" class="d-none">The password must match old password</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="NewPassword">New Password</label>
                                <input type="password" class="form-control" id="NewPassword" name="password" minLength="6" value="{{ old('password') }}" required/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="NewPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="ConfirmPassword" name="password_confirmation" value="{{ old('password_confirmation') }}" required/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                                <span id="confirm_error" class="d-none">The confirm password and new password must match</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 my-5">
                            <div class="form-group">
                                <button type="submit" id="password_submit" class="btn btn-primary">Change Password<i class="mdi mdi-chevron-right"></i></button>
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
<div class="modal fade" id="modal_close">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Close Account</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to close this account?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
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

            $("#ConfirmPassword").on('change', function() {
                $("#confirm_error").addClass("d-none");
                $("#confirm_error").removeClass("custom-validation-error");
            });

            $("#current").on('change', function() {
                $("#current_error").addClass("d-none");
                $("#current_error").removeClass("custom-validation-error");
            });

            const form = $(".needs-validation");
            $('#password_submit').click(function(event) {
                form.addClass('was-validated');
                var is_valid = false;

                const old = $('#old').val();
                const current = $('#current').val();
                if(current !== old) {
                    $("#current_error").removeClass("d-none");
                    $('#current_error').addClass("custom-validation-error");
                    is_valid = true;
                }

                const newpass = $("#NewPassword").val();
                const confirm = $("#ConfirmPassword").val();

                if(confirm !== newpass) {
                    $("#confirm_error").removeClass("d-none");
                    $("#confirm_error").addClass("custom-validation-error");
                    is_valid = true;
                }

                if(form[0].checkValidity() === false || is_valid) {
                    event.preventDefault();
                    return;
                }

                form.removeClass('was-validated');
            });
        });
        openCloseModal = () => {
            let url = "{{ route('vendors.setting.close') }}";
            let html = $("#modal_close").html().replace('$URL', url);
            $("#modal_close").html(html);
            $("#modal_close").modal("show");
        } 
    </script>
@endsection