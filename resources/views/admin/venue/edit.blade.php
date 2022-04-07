@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Venues</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Venue</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ route('admin.venues.update', $venue->id) }}" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="step-1">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="main-title mb-3">Venue Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="EventName">Venue Name *</label>
                                    <input type="text" class="form-control" id="VenueName" name="name" value="{{ $venue->name }}" />
                                </div>
                                <div class="form-group">
                                    <label for="EventDetails">Venue Details</label>
                                    <textarea class="form-control" rows="5" id="VenueDetails" name="details">{{ $venue->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="file-field addEventHeader">
                                        <div class="addEvent-icon" id="venue-header-image-uploader">
                                            <i class="mdi mdi-image-multiple"></i>
                                            <span>Add Venue Header Image</span>
                                            <span id="venue-header-image-file-name"></span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="">
                                                <input id="venue-header-image" class="d-none" type="file" name="header_image" value="{{ $venue->header_image_path }}"/>
                                                <p>Upload an Image no larger than 10mb in jpeg, png or gif format. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>	
                        <div class="row no-input-border">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="VenueLocation">Address *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="VenueLocation" name="address" value="{{ $venue->address }}" >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-map-marker"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group border-input">
                                    <label for="VenueName">Town/City *</label>
                                    <input type="text" class="form-control" placeholder="" id="VenueCity" name="city" value="{{ $venue->city }}">
                                </div>
                                <div class="form-group border-input">
                                    <label for="VenueName">Postcode *</label>
                                    <input type="text" class="form-control" placeholder="" id="VenuePostcode" name="postcode" value="{{ $venue->postcode }}">
                                </div>
                                <div class="form-group border-input">
                                    <label for="VenueName">Phone Number *</label>
                                    <input type="text" class="form-control" placeholder="" id="VenuePhone" name="phone" value="{{ $venue->phone }}">
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
                                    <input type="time" value="{{ $venue->timetable->mon_open }}" step="60" id="monday-opening-time" name="mon_open" class="form-control" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="monday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue->timetable->mon_close }}" step="60" id="monday-closing-time" name="mon_close" value="{{ old('monday_closing_time') }}" class="form-control" />
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
                                    <input type="time" value="{{ $venue->timetable->tue_open }}" step="60" id="tuesday-opening-time" name="tue_open" class="form-control" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="tuesday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue->timetable->tue_close }}" step="60" id="tuesday-closing-time" name="tue_close" class="form-control" />
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
                                    <input type="time" value="{{ $venue->timetable->wed_open }}" step="60" id="wednesday-opening-time" name="wed_open" class="form-control" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="wednesday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue->timetable->wed_close }}" step="60" id="wednesday-closing-time" name="wed_close" class="form-control" />
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
                                    <input type="time" value="{{ $venue->timetable->thu_open }}" step="60" id="thursday-opening-time" name="thu_open" class="form-control" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="thursday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue->timetable->thu_close }}" step="60" id="thursday-closing-time" name="thu_close" class="form-control" />
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
                                    <input type="time" value="{{ $venue->timetable->fri_open }}" step="60" id="friday-opening-time" name="fri_open" class="form-control" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="friday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue->timetable->fri_close }}" step="60" id="friday-closing-time" name="fri_close" class="form-control" />
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
                                    <input type="time" value="{{ $venue->timetable->sat_open }}" step="60" id="saturday-opening-time" name="sat_open" class="form-control" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="saturday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue->timetable->sat_close }}" step="60" id="saturday-closing-time" name="sat_close" class="form-control" />
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
                                    <input type="time" value="{{ $venue->timetable->sun_open }}" step="60" id="sunday-opening-time" name="sun_open" class="form-control" />
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="sunday-closing-time">Closing Time</label>
                                    <input type="time" value="{{ $venue->timetable->sun_close }}" step="60" id="sunday-closing-time" name="sun_close" class="form-control" />
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
                                            <div id="venue-images-uploader" class="addImages-icon">
                                                <i class="mdi mdi-image-multiple"></i> <span>Add Image</span>
                                                <span id="venue-image-file-names"></span>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-none">
                                                    <input type="file" id="venue-images" name="gallery_image">
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
                                                    <input type="file"  id="venue-video" name="gallery_video">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Video Link: https://www.youtube.com" name="video_link" value="{{ old('video_link') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="facitliies">Facilities</label>
                                        <input type="text" class="form-control" placeholder="" name="facilities" value="{{ $venue->facilities }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="MusicPolicy">Music Policy</label>
                                        <input type="text" class="form-control" placeholder="" name="music_policy" value="{{ $venue->music_policy }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DressCode">Dress Code</label>
                                        <input type="text" class="form-control" placeholder="" name="dress_code" value="{{ $venue->dress_code }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="EventType">Venue Type</label>
                                        <input type="text" class="form-control" placeholder="" name="venue_type" value="{{ old('venue_type') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Perks">Perks</label>
                                        <input type="text" class="form-control" placeholder="" name="perks" value="{{ $venue->perks }}">
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
                            @foreach($venue->offers as $offer)
                            <div id="venue-offer-list" class="col-md-12">
                                <div id="venue-offer-default" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerType">Offer Type</label>
                                            <select class="form-control" name="offer_type[]" value="{{ $offer->type }}">
                                                <option value="Discount">Discount</option>
                                                <option value="Type 2">Type 2</option>
                                                <option value="Type 3">Type 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerQuantity">Offer Quantity</label>
                                            <input type="number" class="form-control" placeholder="00" name="offer_qty[]" value="{{ $offer->qty }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerPrice">Offer Price</label>
                                            <input type="number" class="form-control" placeholder="£00.00" name="offer_price[]" value="{{ $offer->price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerApproval">Offer Approval</label>
                                            <select class="form-control" name="offer_approval[]" value="{{ $offer->approval }}">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Description</label>
                                            <textarea class="form-control" rows="3" name="offer_description[]" placeholder="">{{ $offer->description }}</textarea>
                                        </div>
                                    </div>
                                    <hr class="venue-offer-separator mb-3"/>
                                </div>
                            </div>
                            @endforeach
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
                            @foreach($venue->tables as $table)
                            <div id="venue-table-list" class="col-md-12">
                                <div id="venue-table-default" class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerType">Table Type</label>
                                            <select class="form-control" name="table_type[]" value="{{ $table->type }}">
                                                <option value="Type 1">Type 1</option>
                                                <option value="Type 2">Type 2</option>
                                                <option value="Type 3">Type 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerQuantity">Table Quantity</label>
                                            <input type="number" class="form-control" placeholder="00" name="table_qty[]" value="{{ $table->qty }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerPrice">Table Price</label>
                                            <input type="text" class="form-control" placeholder="£00.00" name="table_price[]" value="{{ $table->price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="offerApproval">Booking Approval</label>
                                            <select class="form-control" name="table_booking_approval[]" value="{{ $table->approval }}">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Description</label>
                                            <textarea class="form-control" rows="3" placeholder="" name="table_description[]">{{ $table->description }}</textarea>
                                        </div>
                                    </div>
                                    <hr class="venue-table-separator mb-3"/>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-md-12">
                                <a id="add-venue-table" class="add-another-link"><i class="mdi mdi-plus"></i> Add another table</a>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-6">
                                <button id="venue-form-back" type="button" class="btn btn-primary"><i class="mdi mdi-chevron-left"></i> Back</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Update an venue <i class="mdi mdi-chevron-right"></i></button>
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
            $("#venue-header-image-uploader").on('click', function(){
                $("#venue-header-image").click();
            });
            $("#venue-header-image").on('change', function(){
                $("#venue-header-image-file-name").text($(this)[0].files[0].name);
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