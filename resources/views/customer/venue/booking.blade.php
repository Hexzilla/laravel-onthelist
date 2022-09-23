@extends('layouts.customer')

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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Venues</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Booking</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ route('customers.venues.createBooking') }}" class="EventForm needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-3">Booking Information</h4>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="from-group">
                                <label for="venue">Venue *</label>
                                <input type="text" class="form-control" id="venue" name="venue" value="{{$venue->name}}" readonly>
                                <input type="hidden" id="venue_id" name="venue_id" value="{{$venue->id}}">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="from-group">
                                <label for="event">Booking Type *</label>
                                <select class="form-control" id="booking_type" name="booking_type" required>
                                    <option disabled selected>Select Booking Type</option>
                                    <option value="Table">Table Booking</option>
                                    <option value="Offer">Offers</option>
                                </select>
                                <span id="booking_type_error" class="d-none" role="alert">This field is required</span>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="type">Type *</label>
                                <select class="form-control display-booking"></select>
                                <select class="form-control d-none display-booking" id="tables" name="type">
                                    @foreach($venue->tables as $table)
                                        <option value="{{$table->type}}" data-price="{{$table->price}}">{{$table->type}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control d-none display-booking" id="offers" name="type">
                                    @foreach($venue->offers as $offer)
                                        <option value="{{$offer->type}}" data-price="{{$offer->price}}">{{$offer->type}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price">Price *</label>
                                <input type="number" class="form-control" placeholder="£0" id="price" name="price" step="any" required/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="date" class="form-control text-center event-date-time" min="{{date('Y-m-d')}}" value = "{{date('Y-m-d')}}" required/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" id="time" name="time" class="form-control text-center event-date-time" value = "00:00" required/>
                                <span class="invalid-feedback" role="alert">This field is required</span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-6">
                            <button id="submit-button" type="submit" class="btn btn-primary">Create a Booking</button>
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
        function changePrice(e) {
            const price = $(e).find("option:selected").attr('data-price');
            $("#price").val(price);
        };

        function changeSelectOption() {
            var booking_type = $("#booking_type option:selected").val();
            $(".display-booking").addClass("d-none");
            if (booking_type === "Table") {
                $("#tables").removeClass("d-none");
                changePrice("#tables");
                $("#tables").on('change', function() {
                    changePrice("#tables");
                });
            } else if (booking_type === "Offer") {
                $("#offers").removeClass("d-none");
                changePrice("#offers");
                $("#offers").on('change', function() {
                    changePrice("#offers");
                })
            }
        }

        $("#booking_type").on('change', function() {
            changeSelectOption();
        });

        $("#booking_type").on('change', function() {
            $('#booking_type_error').addClass('d-none');
            $('#booking_type_error').removeClass('custom-validation-error');
        });

        const form = $(".needs-validation");
        $("#submit-button").on('click', function(){
            form.addClass('was-validated');
            var is_valid = false;

            if ($('#booking_type').val() === null) {
                $('#booking_type_error').removeClass('d-none');
                $('#booking_type_error').addClass('custom-validation-error');
                is_valid = true;
            }

            if(form[0].checkValidity() === false || is_valid) {
                event.preventDefault();
                return;
            };
            form.removeClass('was-validated');
        });
    });
</script>
@endsection