@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Events</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ $action }}" class="EventForm needs-validation" enctype="multipart/form-data">
                    @csrf
                    @isset($event)
                        @method('PUT')
                    @endif
                    <div id="step-1">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="main-title mb-3">Event Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Event Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                        value="{{ $event? $event->name : old('name') }}" required />
                                    <span class="invalid-feedback" role="alert">This field is required</span>
                                </div>
                                <div class="form-group">
                                    <label for="EventDetails">Event Details</label>
                                    <textarea class="form-control" rows="5" id="EventDetails" name="details">{{ $event ? $event->description : old('details') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="file-field addEventHeader" id="header_image_wrapper">
                                        <div class="addEvent-icon" id="header-image-uploader">
                                            <i class="mdi mdi-image-multiple"></i>
                                            <span>Add Event Header Image</span>
                                            <span id="header-image-file-name">{{ $event ? $event->header_image_path : old('header_image') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="">
                                                <input id="header-image" class="d-none" type="file" name="header_image"
                                                    value="{{ $event ? $event->header_image_path : old('header_image') }}"/>
                                                <p>Upload an Image no larger than 10mb in jpeg, png or gif format. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="header_image_error" class="d-none" role="alert">This field is required</span>
                                </div>
                                <div class="form-group">
                                    <label for="EventType">Event Type *</label>
                                    <select class="form-control" id="event-type" name="type">
                                        <option disabled {{ $event ? '' : 'selected'}}>Select Event Type</option>
                                        <option value="Public" {{ ($event && $event->type === 'Public') ? 'selected' : '' }}>Public</option>
                                        <option value="Private" {{ ($event && $event->type === 'Public') ? 'selected' : '' }}>Private</option>
                                    </select>
                                    <span id="event-type-error" class="d-none" role="alert">This field is required</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="start-date">Start Date</label>
                                <input type="date" value="{{ $starts ? $starts[0] : date('Y-m-d') }}" id="start-date" name="start_date" class="form-control text-center event-date-time" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="start-time">Start Time</label>
                                <input type="time" value="{{ $starts ? $starts[1] : '00:00' }}" step="60" id="start-time" name="start_time" class="form-control text-center event-date-time" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="end-date">End Date</label>
                                <input type="date" value="{{ $ends ? $ends[0] : date('Y-m-d') }}" id="end-date" name="end_date" class="form-control text-center event-date-time" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end-time">End Time</label>
                                <input type="time" value="{{ $ends ? $ends[1] : '00:00' }}" step="60" id="end-time" name="end_time" class="form-control text-center event-date-time" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-check">
                                    <input class="form-check-input" type="checkbox" name="is_weekly_event" @if(old('is_weekly_event') == 'on') checked @endif>
                                    <label class="form-check-label">
                                        Weekly Event
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="event_venue">Venue *</label>
                                    <select class="form-control" id="event_venue" name="venue_id">
                                        <option disabled selected>Select Venue</option>
                                        @foreach($venues as $venue)
                                        <option value="{{$venue->id}}" data-venue-location="{{$venue->location}}" {{ ($event && $event->venue_id === $venue->id) ? 'selected' : '' }}>{{$venue->name}}</option>
                                        @endforeach
                                    </select>
                                    <span id='event_venue_error' class="d-none" role="alert">This field is required</span>
                                </div>
                                <div class="form-group border-input">
                                    <label for="venue_location">Venue Location</label>
                                    <input type="text" class="form-control" placeholder="" id="venue_location"/>
                                </div>
                                <div class="form-group">
                                    <label for="djs">DJ's *</label>
                                    <select class="form-control multi-select" id="djs" name="djs[]" multiple required>
                                        @foreach($djs as $dj)
                                        <option value="{{$dj->id}}" {{ $dj->selected }}>{{$dj->user->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" role="alert">This field is required</span>
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
                                            <div id="images-uploader" class="addImages-icon">
                                                <i class="mdi mdi-image-multiple"></i> <span>Add Image</span>
                                                <span id="image-file-names"></span>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-none">
                                                    <input type="file" id="images" name="gallery_image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="file-field">
                                            <div id="video-uploader" class="addImages-icon">
                                                <i class="mdi mdi-video"></i> <span>Video</span>
                                                <span id="venue-video-file-name"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group d-none" id="video-link">
                                        <input type="text" class="form-control" placeholder="Video Link: https://www.youtube.com" name="video_link" value="{{ old('video_link') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 my-5">
                                    <div class="form-group">
                                        <button type="button" id="event-form-next" class="btn btn-primary">Next Step <i class="mdi mdi-chevron-right"></i></button>
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
                                <h4 class="main-title">Add Tickets</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div id="event-ticket-list" class="col-md-12">
                                @if(is_null($event))
                                    @include("vendor.event.ticket", ['ticket' => null])
                                @else
                                    @foreach($event->tickets as $ticket)
                                        @include("vendor.event.ticket", ['ticket' => $ticket])
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-12">
                                <a id="add-event-ticket" class="add-another-link"><i class="mdi mdi-plus"></i> Add another ticket</a>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-12">
                                <h4 class="main-title">Add Tables</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div id="event-table-list" class="col-md-12">
                                @if(is_null($event))
                                    @include("vendor.event.table", ['table' => null])
                                @else
                                    @foreach($event->tables as $table)
                                        @include("vendor.event.table", ['table' => $table])
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-12">
                                <a id="add-event-table" class="add-another-link"><i class="mdi mdi-plus"></i> Add another table</a>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-12">
                                <h4 class="main-title">Add Guestlist</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div id="event-guestlist-list" class="col-md-12">
                                @if(is_null($event))
                                    @include("vendor.event.guestlist", ['guestlist' => null])
                                @else
                                    @foreach($event->guestlists as $guestlist)
                                        @include("vendor.event.guestlist", ['guestlist' => $guestlist])
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-12">
                                <a id="add-event-guestlist" class="add-another-link"><i class="mdi mdi-plus"></i> Add another guestlist</a>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-6">
                                <button id="event-form-back" type="button" class="btn btn-primary"><i class="mdi mdi-chevron-left"></i> Back</button>
                            </div>
                            <div class="col-md-6">
                                <button id="submit-button" type="submit" class="btn btn-primary">{{ $event ? 'Update' : 'Create'}} an Event <i class="mdi mdi-chevron-right"></i></button>
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
        $('.multi-select').select2();
        // Header Image
        $("#header-image-uploader").on('click', function(){
            $("#header-image").click();
        });
        $("#header-image").on('change', function(){
            $("#header-image-file-name").text($(this)[0].files[0].name);
            $('#header_image_wrapper').css('border-color', '#dddee3');
            $('#header_image_error').addClass('d-none');
            $('#header_image_error').removeClass('custom-validation-error');
        });

        // Gallery Images
        $("#images-uploader").on('click', function(){
            $("#images").click();
        });
        $("#images").on('change', function(){
            $("#image-file-names").text(`(${$(this)[0].files[0].name})`);
        });

        // Gallery video
        $("#video-uploader").on('click', function(){
            $("#video-link").removeClass('d-none');
        });
        
        if($('#event-type').val() === 'Public') {
            $(".approval").each((index, ele) => $(ele).val("No"));
            $(".approval").prop("disabled", true);
        }

        $('#event-type').on('change', function(){
            $('#event-type-error').removeClass('custom-validation-error');
            $('#event-type-error').addClass('d-none');
            if($('#event-type').val() === 'Public') {
                $(".approval").each((index, ele) => $(ele).val("No"));
                $(".approval").prop("disabled", true);
            } else if($("#event-type").val() === 'Private') {
                $(".approval").prop("disabled", false);
            }
        });

        $('#event_venue').on('change', function(){
            $('#event_venue_error').removeClass('custom-validation-error');
            $('#event_venue_error').addClass('d-none');
        });

        // Step switch
        const form = $(".needs-validation");
        $("#event-form-next").on('click', function(){
            form.addClass('was-validated');
            var is_valid = false;

            if ($('#header-image-file-name').html() == '') {
                $('#header_image_wrapper').css('border-color', '#FD5190');
                $('#header_image_error').removeClass('d-none');
                $('#header_image_error').addClass('custom-validation-error');
                is_valid = true;
            }

            if ($('#event-type').val() === null) {
                $('#event-type-error').addClass('custom-validation-error');
                $('#event-type-error').removeClass('d-none');
                is_valid = true;
            };

            if ($('#event_venue').val() == null) {
                $('#event_venue_error').addClass('custom-validation-error');
                $('#event_venue_error').removeClass('d-none');
                is_valid = true;
            }

            if (form[0].checkValidity() === false || is_valid) {
                event.preventDefault();
                return;
            }
            
            form.removeClass('was-validated');
            $("#step-1").addClass('d-none');
            $("#step-2").removeClass('d-none');
        });

        $("#event-form-back").on('click', function(){
            $("#step-1").removeClass('d-none');
            $("#step-2").addClass('d-none');
        });

        const location = $("#event_venue option:selected").attr('data-venue-location');
        $('#venue_location').val(location);

        $("#event_venue").on('change', function(e) {
            const location = $("#event_venue option:selected").attr('data-venue-location');
            $('#venue_location').val(location);
        });

        const booking_types = ['EarlyBird', 'Standard', 'VIP'];
        $(".ticket_type").autocomplete({
            source: booking_types,
            minLength: 0,
        }).focus(function () {
            $(this).autocomplete('search', $(this).val())
        });

        $(".table_type").autocomplete({
            source: booking_types,
            minLength: 0,
        }).focus(function () {
            $(this).autocomplete('search', $(this).val())
        });

        $(".guestlist_type").autocomplete({
            source: booking_types,
            minLength: 0,
        }).focus(function () {
            $(this).autocomplete('search', $(this).val())
        });

        // Show remove buttons
        function showRemoveButtons() {
            if ($('.event-guestlist').length > 1) {
                $(".remove-event-guestlist").removeClass('d-none');
            } else {
                $(".remove-event-guestlist").addClass('d-none');
            }

            if ($('.event-ticket').length > 1) {
                $(".remove-event-ticket").removeClass('d-none');
            } else {
                $(".remove-event-ticket").addClass('d-none');
            }
            
            if ($('.event-table').length > 1) {
                $(".remove-event-table").removeClass('d-none');
            } else {
                $(".remove-event-table").addClass('d-none');
            }
        }
        showRemoveButtons();

        function removeEventTicket() {
            $('.remove-event-ticket').on('click', function() {
                if($(".event-ticket").length === 1) {
                    return;
                }
                $(this).parent().parent().remove();
                showRemoveButtons();
            });
        }
        removeEventTicket();

        // Event ticket
        $("#add-event-ticket").on('click', function(){
            var new_ticket = $("#event-ticket-default").clone();
            $(new_ticket).find("input, textarea").each((index, ele)=> $(ele).val(""));
            $(new_ticket).find(".ticket_type").eq(0).autocomplete({
                source: booking_types,
                minLength: 0,
            }).focus(function () {
                $(this).autocomplete('search', $(this).val())
            });
            new_ticket.appendTo("div#event-ticket-list");
            removeEventTicket();
            showRemoveButtons();
        });

        function removeEventTable() {
            $('.remove-event-table').on('click', function() {
                if($(".event-table").length === 1) {
                    return;
                }
                $(this).parent().parent().remove();
                showRemoveButtons();
            });
        }
        removeEventTable();

        // Event table
        $("#add-event-table").on('click', function(){
            var new_table = $("#event-table-default").clone();
            $(new_table).find("input, textarea").each((index, ele)=> $(ele).val(""));
            $(new_table).find(".table_type").eq(0).autocomplete({
                source: booking_types,
                minLength: 0,
            }).focus(function () {
                $(this).autocomplete('search', $(this).val())
            });
            new_table.appendTo("div#event-table-list");
            removeEventTable();
            showRemoveButtons();
        });
    
        // Event guestlist
        function removeEventGuest() {
            $('.remove-event-guestlist').on('click', function() {
                if($(".event-guestlist").length === 1) {
                    return;
                }
                $(this).parent().parent().remove();
                showRemoveButtons();
            });
        }
        removeEventGuest();

        $("#add-event-guestlist").on('click', function(){
            var new_guestlist = $("#event-guestlist-default").clone();
            $(new_guestlist).find("input, textarea").each((index, ele)=> $(ele).val(""));
            $(new_guestlist).find(".guestlist_type").eq(0).autocomplete({
                source: booking_types,
                minLength: 0,
            }).focus(function () {
                $(this).autocomplete('search', $(this).val())
            });
            new_guestlist.appendTo("div#event-guestlist-list");
            removeEventGuest();
            showRemoveButtons();
        });

        function formatDate(date) {
            return date.toISOString().slice(0, 10);
        }

        function getDateTime(str) {
            return new Date(str).getTime();
        }

        function updateEndDateTime() {
            const startDate = $('#start-date').val();
            const endDate = $('#end-date').val();

            $('#end-date').attr('min', startDate)

            if (getDateTime(startDate) > getDateTime(endDate)) {
                $('#end-date').val(startDate)
                return;
            }

            const startTime = $('#start-time').val();
            const endTime = $('#end-time').val();
            const date1 = `${startDate} ${startTime}:00`;
            const date2 = `${endDate} ${endTime}:00`;
            if (getDateTime(date1) > getDateTime(date2)) {
                $('#end-time').val(startTime)
            }
        }
        updateEndDateTime();
        
        // Event Date and Times
        $('.event-date-time').on('change', function() {
            updateEndDateTime();
        })
        
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
        const input = document.getElementById("venue_location");
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