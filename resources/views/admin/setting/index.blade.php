@extends('layouts.admin')

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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Setting</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ route('admin.setting.password') }}" class="EventForm needs-validation" enctype="multipart/form-data">
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
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
    </script>
@endsection