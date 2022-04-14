@extends('layouts.dj')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">DJ Profile</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Profile</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ route('dj.profile.store') }}" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="step-1">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="main-title mb-3">Profile Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="FullName">Full Name *</label>
                                    <input type="text" class="form-control" id="FullName" name="name" value="{{ $user->name }}" />
                                </div>
                                <div class="form-group">
                                    <label for="Email">Email *</label>
                                    <input type="email" class="form-control" id="Email" name="email" value="{{ $user->email }}" />
                                </div>
                            </div>
                        </div>	
                        <div class="row no-input-border">
                            <div class="col-md-12">
                                <div class="form-group border-input">
                                    <label for="Genres">Genres *</label>
                                    @if(count($user->profile) > 0)
                                    <input type="text" class="form-control" placeholder="" id="Genres" name="genres" value="{{ $user->profile[0]->genres }}">
                                    @else
                                    <input type="text" class="form-control" placeholder="" id="Genres" name="genres" value="{{ '' }}">
                                    @endif
                                </div>
                                <div class="form-group border-input">
                                    <label for="Age">Age *</label>
                                    @if(count($user->profile) > 0)
                                    <input type="number" class="form-control" placeholder="" id="Age" name="age" value="{{ $user->profile[0]->age }}">
                                    @else
                                    <input type="number" min="1" class="form-control" placeholder="" id="Genres" name="genres" value="{{ '' }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="gallery-uploads">
                            <div class="row my-5">
                                <div class="col-md-12">
                                    <h4 class="main-title">Media Uploads</h4>
                                </div>
                            </div>	
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="file-field">
                                            <div id="venue-images-uploader" class="addImages-icon">
                                                <i class="mdi mdi-image-multiple"></i> <span>Add Image</span>
                                                <span id="venue-image-file-names"></span>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-none">
                                                    <input type="file" id="venue-images" name="gallery_image" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="file-field">
                                            <div id="venue-video-uploader" class="addImages-icon">
                                                <i class="mdi mdi-video"></i> <span>Video</span>
                                                <span id="venue-video-file-name"></span>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-none">
                                                    <input type="file"  id="venue-video" name="gallery_video" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-5">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create Profile <i class="mdi mdi-chevron-right"></i></button>
                                    </div>
                                </div>
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
        $(document).ready(function(){
            // Header Image
            $("#v-header-image-uploader").on('click', function(){
                $("#v-header-image").click();
            });
            $("#v-header-image").on('change', function(){
                $("#v-header-image-file-name").text($(this)[0].files[0].name);
            });

            // Gallery Images
            $("#venue-images-uploader").on('click', function(){
                $("#venue-images").click();
            });
            $("#venue-images").on('change', function(){
                $("#venue-image-file-names").text(`(${$(this)[0].files[0].name})`);
            });

            // Gallery video
            $("#venue-video-uploader").on('click', function(){
                $("#venue-video").click();
            });
            $("#venue-video").on('change', function(){
                $("#venue-video-file-name").text(`(${$(this)[0].files[0].name})`);
            });

            // Step switch
            $("#venue-form-next").on('click', function(){
                $("#step-1").addClass('d-none');
                $("#step-2").removeClass('d-none');
            });

            $("#venue-form-back").on('click', function(){
                $("#step-1").removeClass('d-none');
                $("#step-2").addClass('d-none');
            });

            // Venue offer
            $("#add-venue-offer").on('click', function(){
                var new_offer = $("#venue-offer-default").clone();
                $(new_offer).find("input, textarea").each((index, ele)=> $(ele).val(""));
                new_offer.appendTo("div#venue-offer-list");
            });

            // Venue table
            $("#add-venue-table").on('click', function(){
                var new_table = $("#venue-table-default").clone();
                $(new_table).find("input, textarea").each((index, ele)=> $(ele).val(""));
                new_table.appendTo("div#venue-table-list");
            });
        });
    </script>
@endsection