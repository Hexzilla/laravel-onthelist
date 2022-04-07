@extends('layouts.vendor')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Events</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Event</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ route('event.update', $event->id) }}" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="step-1">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="main-title mb-3">Event Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="EventName">Event Name *</label>
                                    <input type="text" class="form-control" id="EventName" name="name" value="{{ $event->name }}" />
                                </div>
                                <div class="form-group">
                                    <label for="EventDetails">Event Details</label>
                                    <textarea class="form-control" rows="5" id="EventDetails" name="details">{{ $event->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="file-field addEventHeader">
                                        <div class="addEvent-icon" id="header-image-uploader">
                                            <i class="mdi mdi-image-multiple"></i>
                                            <span>Add Event Header Image</span>
                                            <span id="header-image-file-name"></span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="">
                                                <input id="header-image" class="d-none" type="file" name="header_image" value="{{ $event->header_image_path }}"/>
                                                <p>Upload an Image no larger than 10mb in jpeg, png or gif format. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="EventType">Event Type *</label>
                                    <select class="form-control" id="EventType" name="type" value="{{ $event->type }}">
                                        <option disabled>Select Event Type</option>
                                        <option value="Type 1">Type 1</option>
                                        <option value="Type 2">Type 2</option>
                                        <option value="Type 3">Type 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="start-date">Start Date</label>
                                <input type="date" value="{{ old('start_date') ?? date('Y-m-d') }}" id="start-date" name="start_date" class="form-control" />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="start-time">Start Time</label>
                                <input type="time" value="{{ old('start_time') ?? "09:00" }}" step="60" id="start-time" name="start_time" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="end-date">End Date</label>
                                <input type="date" value="{{ old('end_date') ?? date('Y-m-d') }}" id="end-date" name="end_date" class="form-control" />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="end-time">End Time</label>
                                <input type="time" value="{{ old('end_time') ?? "20:00" }}" step="60" id="end-time" name="end_time" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="EventVenue">Venue *</label>
                                    <select class="form-control" id="EventVenue" name="venue_id" value="{{$event->venue_id}}">
                                        <option disabled>Select Venue</option>
                                        @foreach($venues as $venue)
                                        <option value="{{$venue->id}}" data-venue-location="{{$venue->location}}">{{$venue->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group border-input">
                                    <label for="EventName">Venue Location</label>
                                    <input type="text" class="form-control" placeholder="" id="VenueLocation"/>
                                </div>
                                <div class="form-group">
                                    <label for="facitliies">DJ's</label>
                                    <select class="form-control multi-select" name="djs[]" multiple>
                                        @foreach($djs as $dj)
                                        <option value="{{$dj->id}}">{{$dj->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                                                <span id="video-file-name"></span>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-none">
                                                    <input type="file" id="video" name="gallery_video">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
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
                                <div id="event-ticket-default" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ticketType">Ticket Type</label>
                                            <select class="form-control" name="ticket_type[]">
                                                <option value="Standard">Standard</option>
                                                <option value="Low">Low</option>
                                                <option value="High">High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ticketQuantity">Ticket Quantity</label>
                                            <input type="number" class="form-control" placeholder="00" name="ticket_qty[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ticketPrice">Ticket Price</label>
                                            <input type="number" class="form-control" placeholder="£00.00" name="ticket_price[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ticketApproval">Booking Approval</label>
                                            <select class="form-control" name="ticket_approval[]">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Description</label>
                                            <textarea class="form-control" rows="3" name="ticket_description[]" placeholder=""></textarea>
                                        </div>
                                    </div>
                                    <hr class="venue-table-separator mb-3"/>
                                </div>
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
                                <div id="event-table-default" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tableType">Table Type</label>
                                            <select class="form-control" name="table_type[]">
                                                <option value="Type 1">Type 1</option>
                                                <option value="Type 2">Type 2</option>
                                                <option value="Type 3">Type 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tableQuantity">Table Quantity</label>
                                            <input type="number" class="form-control" placeholder="00" name="table_qty[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tablePrice">Table Price</label>
                                            <input type="text" class="form-control" placeholder="£00.00" name="table_price[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tableApproval">Booking Approval</label>
                                            <select class="form-control" name="table_booking_approval[]">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Description</label>
                                            <textarea class="form-control" rows="3" placeholder="" name="table_description[]"></textarea>
                                        </div>
                                    </div>
                                    <hr class="venue-table-separator mb-3"/>
                                </div>
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
                                <div id="event-guestlist-default" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guestlistType">Guestlist Type</label>
                                            <select class="form-control" name="guestlist_type[]">
                                                <option value="Type 1">Type 1</option>
                                                <option value="Type 2">Type 2</option>
                                                <option value="Type 3">Type 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guestlistQuantity">Guestlist Quantity</label>
                                            <input type="number" class="form-control" placeholder="00" name="guestlist_qty[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guestlistPrice">Guestlist Price</label>
                                            <input type="text" class="form-control" placeholder="£00.00" name="guestlist_price[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guestlistApproval">Booking Approval</label>
                                            <select class="form-control" name="guestlist_booking_approval[]">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Description</label>
                                            <textarea class="form-control" rows="3" placeholder="" name="guestlist_description[]"></textarea>
                                        </div>
                                    </div>
                                    <hr class="venue-table-separator mb-3"/>
                                </div>
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
                                <button type="submit" class="btn btn-primary">Create an Event <i class="mdi mdi-chevron-right"></i></button>
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
                $("#video").click();
            });
            $("#video").on('change', function(){
                $("#video-file-name").text(`(${$(this)[0].files[0].name})`);
            });

            // Step switch
            $("#event-form-next").on('click', function(){
                $("#step-1").addClass('d-none');
                $("#step-2").removeClass('d-none');
            });

            $("#event-form-back").on('click', function(){
                $("#step-1").removeClass('d-none');
                $("#step-2").addClass('d-none');
            });

            // Event ticket
            $("#add-event-ticket").on('click', function(){
                var new_ticket = $("#event-ticket-default").clone();
                $(new_ticket).find("input, textarea").each((index, ele)=> $(ele).val(""));
                new_ticket.appendTo("div#event-ticket-list");
            });

            // Event table
            $("#add-event-table").on('click', function(){
                var new_table = $("#event-table-default").clone();
                $(new_table).find("input, textarea").each((index, ele)=> $(ele).val(""));
                new_table.appendTo("div#event-table-list");
            });

            // Event guestlist
            $("#add-event-guestlist").on('click', function(){
                var new_guestlist = $("#event-guestlist-default").clone();
                $(new_guestlist).find("input, textarea").each((index, ele)=> $(ele).val(""));
                new_guestlist.appendTo("div#event-guestlist-list");
            });
        });
    </script>
@endsection