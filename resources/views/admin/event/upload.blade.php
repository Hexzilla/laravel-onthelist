@extends('layouts.admin')

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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Events</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Upload Feature Image</a></li>
                </ol>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ route('admin.events.uploadImage', $event->id) }}" class="EventForm needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-3">Upload Feature Image</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="file-field addEventFeature" id="feature_image_wrapper">
                                    <div class="addEvent-icon" id="feature-image-uploader">
                                        <i class="mdi mdi-image-multiple"></i>
                                        <span>Add Event Feature Image</span>
                                        <span id="feature-image-file-name">{{ $event->feature_image_path ?? old('feature_image_path') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <input id="feature-image" class="d-none" type="file" name="feature_image"
                                            value="{{ $event->feature_image_path ?? old('feature_image') }}"/>
                                        <p>Upload an Image no larger than 10 mb in jpeg, png or gif format. </p>
                                    </div>
                                </div>
                                <span id="feature_image_error" class="d-none" role="alert">This field is required</span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-6">
                            <button id="submit-button" type="submit" class="btn btn-primary">Upload Feature Image</button>
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
    $("#feature-image-uploader").on('click', function(){
        $("#feature-image").click();
    });
    $("#feature-image").on('change', function(){
        $("#feature-image-file-name").text($(this)[0].files[0].name);
        $('#feature_image_wrapper').css('border-color', '#dddee3');
        $('#feature_image_error').addClass('d-none');
        $('#feature_image_error').removeClass('custom-validation-error');
    });
</script>
@endsection