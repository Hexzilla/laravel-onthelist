@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Venues</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $title }} Venue</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ $action }}" class="EventForm needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    @if(isset($venue))
                    @method('PUT')
                    @endif
                    <div id="step-1">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="main-title mb-3">Venue Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Venue Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $venue? $venue->name : old('name') }}" required />
                                    <span class="invalid-feedback" role="alert">This field is required</span>
                                </div>
                                <div class="form-group">
                                    <label for="EventDetails">Venue Details</label>
                                    <textarea class="form-control" rows="5" id="VenueDetails" name="details">{{ $venue? $venue->description : old('details') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="file-field addEventHeader" id="header_image_wrapper">
                                        <div class="addEvent-icon" id="v-header-image-uploader">
                                            <i class="mdi mdi-image-multiple"></i>
                                            <span>Add Venue Header Image</span>
                                            <span id="v-header-image-file-name">{{ $venue? $venue->header_image_path : old('header_image') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="">
                                                <input id="v-header-image" class="d-none" type="file" name="header_image" 
                                                    value="{{ $venue? $venue->header_image_path : old('header_image') }}"/>
                                                <p>Upload an Image no larger than 10mb in jpeg, png or gif format. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="header_iamge_error" class="d-none" role="alert">This field is required</span>
                                </div>
                            </div>
                        </div>	
                        <div class="row no-input-border">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="VenueLocation">Address *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="VenueLocation" name="address" value="{{ $venue? $venue->address : old('address') }}" required >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-map-marker"></i></span>
                                        </div>
                                        <span class="invalid-feedback" role="alert">This field is required</span>
                                    </div>
                                </div>
                                <div class="form-group border-input">
                                    <label for="city">Town/City</label>
                                    <input type="text" class="form-control" placeholder="" id="city" name="city" value="{{ $venue? $venue->city : old('city') }}" required>
                                    <!-- <select class="form-control" name="city">
                                        @foreach($cities as $city)
                                            @if($venue && $venue->city == $city->name)
                                                <option value="{{ $city->name }}" selected>{{ $city->name }}</option>
                                            @else
                                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                            @endif
                                        @endforeach
                                    </select> -->
                                    <span class="invalid-feedback" role="alert">This field is required</span>
                                </div>
                                <div class="form-group border-input">
                                    <label for="postcode">Postcode *</label>
                                    <input type="text" class="form-control" placeholder="" id="postcode" name="postcode" value="{{ $venue? $venue->postcode : old('postcode') }}" required>
                                    <span class="invalid-feedback" role="alert">This field is required</span>
                                </div>
                                <div class="form-group border-input">
                                    <label for="phone">Phone Number *</label>
                                    <input type="text" class="form-control" pattern="^\d{11}$" placeholder="07912349988" id="phone" name="phone" value="{{ $venue? $venue->phone : old('phone') }}" required>
                                    <span class="invalid-feedback" role="alert">Please enter 11 digit mobile number</span>
                                </div>
                            </div>
                        </div>
                        <div class="opening-times">
                            <div class="row my-5">
                                <div class="col-md-12">
                                    <h4 class="main-title">Opening Times</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="monday-label">&nbsp;</label>
                                    <div id="monday-label">
                                        <h5 class="weekday-label">Monday</h5>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="monday-opening-time">Opening Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->mon_open : old('mon_open') ?? '00:00' }}" 
                                        step="60" id="monday-opening-time" name="mon_open" class="form-control text-center" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="monday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->mon_close : old('mon_close') ?? '00:00' }}" 
                                        step="60" id="monday-closing-time" name="mon_close" class="form-control text-center" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="tuesday-label">&nbsp;</label>
                                    <div id="tuesday-label">
                                        <h5 class="weekday-label">Tuesday</h5>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="tuesday-opening-time">Opening Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->tue_open : old('tue_open') ?? '00:00' }}" 
                                        step="60" id="tuesday-opening-time" name="tue_open" class="form-control text-center" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="tuesday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->tue_close : old('tue_close') ?? '00:00' }}" 
                                        step="60" id="tuesday-closing-time" name="tue_close" class="form-control text-center" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="wednesday-label">&nbsp;</label>
                                    <div id="wednesday-label">
                                        <h5 class="weekday-label">Wednesday</h5>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="wednesday-opening-time">Opening Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->wed_open : old('wed_open') ?? '00:00' }}" 
                                        step="60" id="wednesday-opening-time" name="wed_open" class="form-control text-center" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="wednesday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->wed_close : old('wed_close') ?? '00:00' }}" 
                                        step="60" id="wednesday-closing-time" name="wed_close" class="form-control text-center" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="thursday-label">&nbsp;</label>
                                    <div id="thursday-label">
                                        <h5 class="weekday-label">Thursday</h5>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="thursday-opening-time">Opening Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->thu_open : old('thu_open') ?? '00:00' }}" 
                                        step="60" id="thursday-opening-time" name="thu_open" class="form-control text-center" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="thursday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->thu_close : old('thu_close') ?? '00:00' }}" 
                                        step="60" id="thursday-closing-time" name="thu_close" class="form-control text-center" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="friday-label">&nbsp;</label>
                                    <div id="friday-label">
                                        <h5 class="weekday-label">Friday</h5>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="friday-opening-time">Opening Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->fri_open : old('fri_open') ?? '00:00' }}" 
                                        step="60" id="friday-opening-time" name="fri_open" class="form-control text-center" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="friday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->fri_close : old('fri_close') ?? '00:00' }}" 
                                        step="60" id="friday-closing-time" name="fri_close" class="form-control text-center" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="saturday-label">&nbsp;</label>
                                    <div id="saturday-label">
                                        <h5 class="weekday-label">Saturday</h5>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="saturday-opening-time">Opening Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->sat_open : old('sat_open') ?? '00:00' }}" 
                                        step="60" id="saturday-opening-time" name="sat_open" class="form-control text-center" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="saturday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->sat_close : old('sat_close') ?? '00:00' }}" 
                                        step="60" id="saturday-closing-time" name="sat_close" class="form-control text-center" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="sunday-label">&nbsp;</label>
                                    <div id="sunday-label">
                                        <h5 class="weekday-label">Sunday</h5>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="sunday-opening-time">Opening Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->sun_open : old('sun_open') ?? '00:00' }}" 
                                        step="60" id="sunday-opening-time" name="sun_open" class="form-control text-center" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="sunday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue && $venue->timetable ? $venue->timetable->sun_close : old('sun_close') ?? '00:00' }}" 
                                        step="60" id="sunday-closing-time" name="sun_close" class="form-control text-center" />
                                </div>
                            </div>
                        </div>
                        <div class="gallery-uploads">
                            <div class="row my-5">
                                <div class="col-md-12">
                                    <h4 class="main-title">Gallery Uploads</h4>
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
                                            <div id="venue-video-uploader" class="addImages-icon">
                                                <i class="mdi mdi-video"></i> <span>Video</span>
                                                <span id="venue-video-file-name"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group d-none" id="video_link">
                                        <input type="text" class="form-control" placeholder="Video Link: https://www.youtube.com" name="video_link" value="{{ old('video_link') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="facitliies">Facilities *</label>
                                        <input type="text" class="form-control" placeholder="" 
                                            name="facilities" value="{{ $venue ? $venue->facilities : old('facilities') }}" required>
                                        <span class="invalid-feedback" role="alert">This field is required</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="music_policy">Music Policy *</label>
                                        <input type="text" class="form-control" placeholder="" 
                                            id="music_policy" name="music_policy" value="{{ $venue ? $venue->music_policy : old('music_policy') }}" required>
                                        <span class="invalid-feedback" role="alert">This field is required</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dress_code">Dress Code *</label>
                                        <input type="text" class="form-control" placeholder="" 
                                            id="dress_code" name="dress_code" value="{{ $venue ? $venue->dress_code : old('dress_code') }}" required>
                                        <span class="invalid-feedback" role="alert">This field is required</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="EventType">Venue Type *</label>
                                        <input type="text" class="form-control" placeholder="" 
                                            id="venue_type" name="venue_type" value="{{ $venue ? $venue->type : old('venue_type') }}" required>
                                        <span class="invalid-feedback" role="alert">This field is required</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Perks">Perks</label>
                                        <input type="text" class="form-control" placeholder="" name="perks" value="{{ $venue ? $venue->perks : old('perks') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 my-5">
                                    <div class="form-group">
                                        <button type="button" id="venue-form-next" class="btn btn-primary">Next Step <i class="mdi mdi-chevron-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step-2" class="d-none">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="main-title">Booking Options</h4>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-12">
                                <h4 class="main-title">Add Offer</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div id="venue-offer-list" class="col-md-12">
                                @if (is_null($venue))
                                    @include("vendor.venue.offer", ['offer' => NULL])
                                @else
                                    @foreach($venue->offers as $offer)
                                        @include("vendor.venue.offer", ['offer' => $offer])
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-12">
                                <a id="add-venue-offer" class="add-another-link"><i class="mdi mdi-plus"></i> Add another offer</a>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-12">
                                <h4 class="main-title">Add Tables</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div id="venue-table-list" class="col-md-12">
                                @if (is_null($venue))
                                    @include("vendor.venue.table", ['table' => NULL])
                                @else
                                    @foreach($venue->tables as $table)
                                        @include("vendor.venue.table", ['table' => $table])
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-12">
                                <a id="add-venue-table" class="add-another-link"><i class="mdi mdi-plus"></i> Add another table</a>
                            </div>
                            
                        </div>
                        <div class="row my-5">
                            <div class="col-md-6">
                                <button id="venue-form-back" type="button" class="btn btn-primary"><i class="mdi mdi-chevron-left"></i> Back</button>
                            </div>
                            <div class="col-md-6">
                                <button id="submit-button" type="submit" class="btn btn-primary">{{ $venue ? 'Update' : 'Create' }} a venue <i class="mdi mdi-chevron-right"></i></button>
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
        $("#venue-video-uploader").on('click', function(){
            $("#video_link").removeClass("d-none");
        });

        $("#venue-form-back").on('click', function(){
            $("#step-1").removeClass('d-none');
            $("#step-2").addClass('d-none');
        });

        // Show remove buttons
        function showRemoveButtons() {
            if ($(".venue-offer").length > 1) {
                $(".remove-venue-offer").removeClass('d-none');
            } else {
                $(".remove-venue-offer").addClass('d-none');
            }
            
            if ($(".venue-table").length > 1) {
                $(".remove-venue-table").removeClass('d-none');
            } else {
                $(".remove-venue-table").addClass('d-none');
            }
        }
        showRemoveButtons();

        // Venue offer
        function removeVenueOffer() {
            $(".remove-venue-offer").on("click", function(){
                if($(".venue-offer").length === 1) {
                    return;
                }
                $(this).parent().parent().remove();
                showRemoveButtons();
            })
        }
        removeVenueOffer();

        $("#add-venue-offer").on('click', function(){
            const new_offer = $("#venue-offer-default").clone();            
            $(new_offer).find("input, textarea").each((index, ele)=> $(ele).val(""));
            new_offer.appendTo("div#venue-offer-list");
            removeVenueOffer();
            showRemoveButtons();
        });

        // Venue table
        function removeVenueTable(){
            $(".remove-venue-table").on("click", function(){
                if($(".venue-table").length === 1){ 
                    return;
                }
                $(this).parent().parent().remove();
                showRemoveButtons();
            })
        }
        removeVenueTable();

        $("#add-venue-table").on('click', function(){
            const new_table = $("#venue-table-default").clone();
            $(new_table).find("input, textarea").each((index, ele)=> $(ele).val(""));
            new_table.appendTo("div#venue-table-list");
            removeVenueTable();
            showRemoveButtons();
        });

        const music_policies = ['Afro Beats', 'Commercial', 'Dance', 'Deep House', 'Dnb', 'Electronic', 'Hip-hop', 'House', 'Indie', 'Jazz', 'Pop', 'Reggae', 'Rnb', 'Rock', 'Tech-House', 'Techno', 'UK Garage']
        $("#music_policy").autocomplete({
            source: music_policies,
            minLength: 0,
        }).focus(function () {
            $(this).autocomplete('search', $(this).val())
        });

        const dress_codes = ['Casual', 'No sportswear', 'Smart', 'Smart-Casual']
        $("#dress_code").autocomplete({
            source: dress_codes,
            minLength: 0,
        }).focus(function () {
            $(this).autocomplete('search', $(this).val())
        });

        const venue_types = ['Bar', 'Festival', 'Nightclub', 'Outdoor', 'Rave', 'Rooftoop']
        $("#venue_type").autocomplete({
            source: venue_types,
            minLength: 0,
        }).focus(function () {
            $(this).autocomplete('search', $(this).val())
        });

        const form = $(".needs-validation");
        $('#venue-form-next').click(function(event) {
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
                event.stopPropagation();
                return;
            }
            
            $('#header_iamge_error').addClass('d-none');
            $('#header_iamge_error').removeClass('custom-validation-error')
            form.removeClass('was-validated');

            $("#step-1").addClass('d-none');
            $("#step-2").removeClass('d-none');
        });

        $('#submit-button').click(function(event) {
            form.addClass('was-validated');

            if (form[0].checkValidity() === false) {
                event.preventDefault();
                return;
            }
            form.removeClass('was-validated');
        });
    });

    function initMap() {
        const input = document.getElementById("VenueLocation");
        const options = {
            fields: ["formatted_address", "geometry", "name"],
            strictBounds: false,
            types: ["establishment"],
        };
        const autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            console.log('place', place)

            if (!place.geometry || !place.geometry.location) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                //window.alert("No details available for input: '" + place.name + "'");
                return;
            }
        });
    }
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap&libraries=places&v=weekly" 
    async
></script>
@endsection