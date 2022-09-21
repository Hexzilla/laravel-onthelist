@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Djs</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $title }} Dj</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ $action }}" class="EventForm needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    @if(isset($dj))
                    @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-3">Dj Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Dj Name *</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $dj? $dj->user->name : old('name') }}" required />
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                            <div class="form-group">
                                <div class="file-field addEventHeader" id="header_image_wrapper">
                                    <div class="addEvent-icon" id="v-header-image-uploader">
                                        <i class="mdi mdi-image-multiple"></i>
                                        <span>Add Dj Profile Image</span>
                                        <span id="v-header-image-file-name">{{ $dj? $dj->header_image_path : old('header_image') }}</span>
                                    </div>
                                    @if (isset($dj))
                                    <input type="hidden" name="header_image_path" value={{$dj->header_image_path}} />
                                    @endif
                                    <div class="d-flex justify-content-center">
                                        <div class="">
                                            <input id="v-header-image" class="d-none" type="file" name="header_image" 
                                                value="{{ $dj? $dj->header_image_path : old('header_image') }}"/>
                                            <p>Upload an Image no larger than 10mb in jpeg, png or gif format. </p>
                                        </div>
                                    </div>
                                </div>
                                <span id="header_iamge_error" class="d-none" role="alert">This field is required</span>
                            </div>
                            <div class="form-group">
                                <label for="description">Dj Details</label>
                                <textarea class="form-control" rows="5" id="description" name="description">{{ $dj? $dj->description : old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group border-input">
                                <label for="mixcloud_link">Dj Mixcloud link:</label>
                                <input type="text" class="form-control" placeholder="https://www.mixcloud.com" id="mixcloud_link" name="mixcloud_link" value="{{ $dj? $dj->mixcloud_link : old('mixcloud_link') }}">
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                            <div class="form-group">
                                <label for="genres">Dj Genre *</label>
                                <select class="form-control multi-select" id="genres" name="genres[]" multiple="multiple" required>
                                    @if (isset($dj))
                                        @foreach($dj->genres as $genre)
                                        <option value="{{ $genre }}" selected>{{ $genre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-uploads">
                        <div class="row my-5">
                            <div class="col-md-12">
                                <h4 class="main-title">Dj Gallery Uploads</h4>
                            </div>
                        </div>	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="file-field">
                                        <div id="v-images-uploader" class="addImages-icon">
                                            <i class="mdi mdi-image-multiple"></i> <span>Add Image</span>
                                            <span id="v-image-file-names"></span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="d-none">
                                                <input type="file" id="v-images" name="gallery_image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="file-field">
                                        <div id="v-video-uploader" class="addImages-icon">
                                            <i class="mdi mdi-video"></i> <span>Video</span>
                                            <span id="v-video-file-name"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group d-none" id="video_link">
                                    <input type="text" class="form-control" placeholder="Video Link: https://www.youtube.com" name="video_link" value="{{ old('video_link') }}">
                                </div>
                            </div>
                            <div class="col-md-6 my-5">
                                <div class="form-group">
                                    <button id="submit-button" type="submit" class="btn btn-primary">{{ $dj ? 'Update' : 'Create' }} an Dj <i class="mdi mdi-chevron-right"></i></button>
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
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.multi-select').select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });

        // Header Image
        $("#v-header-image-uploader").on('click', function(){
            $("#v-header-image").click();
        });
        $("#v-header-image").on('change', function(){
            $('#header_image_wrapper').css('border-color', '#dddee3');
            $('#header_iamge_error').addClass('d-none')
            $("#v-header-image-file-name").text($(this)[0].files[0].name);
        });

        // Gallery Images
        $("#v-images-uploader").on('click', function(){
            $("#v-images").click();
        });
        $("#v-images").on('change', function(){
            $("#v-image-file-names").text(`(${$(this)[0].files[0].name})`);
        });

        // Gallery video
        $("#v-video-uploader").on('click', function(){
            $("#video_link").removeClass("d-none");
        });

        const form = $(".needs-validation");
        $('#submit-button').click(function(event) {
            form.addClass('was-validated');
            var is_valid = false;
            if ($('#v-header-image-file-name').html() == '') {
                $('#header_image_wrapper').css('border-color', '#FD5190');
                $('#header_iamge_error').removeClass('d-none')
                $('#header_iamge_error').addClass('custom-validation-error')
                is_valid = true;
            }

            if (form[0].checkValidity() === false || is_valid) {
                event.preventDefault();
                return;
            }

            $('#header_iamge_error').addClass('d-none');
            $('#header_iamge_error').removeClass('custom-validation-error')
            form.removeClass('was-validated');
        });
    });
</script>
@endsection