@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Venues</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Add City</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ $action }}" class="EventForm needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-3">City Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">City Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required />
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                            <div class="form-group">
                                <div class="file-field addEventHeader" id="header_image_wrapper">
                                    <div class="addEvent-icon" id="v-header-image-uploader">
                                        <i class="mdi mdi-image-multiple"></i>
                                        <span>Add City Image</span>
                                        <span id="v-header-image-file-name">{{ old('header_image') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class="">
                                            <input id="v-header-image" class="d-none" type="file" name="header_image" 
                                                value="{{ old('header_image') }}"/>
                                            <p>Upload an Image no larger than 10mb in jpeg, png or gif format. </p>
                                        </div>
                                    </div>
                                </div>
                                <span id="header_iamge_error" class="d-none" role="alert">This field is required</span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-6">
                            <button id="submit-button" type="submit" class="btn btn-primary">Add City <i class="mdi mdi-chevron-right"></i></a>
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
    $(document).ready(function(){
        $("#v-header-image-uploader").on('click', function(){
            $("#v-header-image").click();
        });
        $("#v-header-image").on('change', function(){
            $('#header_image_wrapper').css('border-color', '#dddee3');
            $('#header_iamge_error').addClass('d-none')
            $("#v-header-image-file-name").text($(this)[0].files[0].name);
        });
    });
</script>
@endsection